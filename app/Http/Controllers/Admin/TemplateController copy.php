<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TemplateModels;
use App\Models\Templates;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategory = Templates::with(['category','subCategory'])->get();
            return DataTables::of($subCategory)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<a href="' . route('template.edit', $row->id) . '" class="btn btn-sm btn-warning btn-round tooltip-toggle edit-template"><i class="nav-icon fas fa-edit"></i></a>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-template" data-original-title="Delete" data-action="' . route('template.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = Category::where('is_deleted', false)->where('parent_id', null)->get();
        $users = User::where('user_type', 0)->get();
        return view('admin.template.index', compact('categories', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_deleted', false)->where('parent_id', null)->get();
        $users = User::where('user_type', 0)->get();
        return view('admin.template.add', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        // Validate the request
        $validator = Validator::make($request->all(), [
            'template_type' => 'required|in:public,custom',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,_id',
            'sub_category_id' => 'required|exists:categories,_id',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id', // Validate user_id if necessary
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Prepare data for creating the Template record
            $data = $request->all();
            $data['status'] = 1;
            $template = Templates::create($data);

            // Extract file fields from request
            $fileFields = array_filter($request->all(), function ($key) {
                return strpos($key, 'background_image_') === 0
                    || strpos($key, 'foreground_image') === 0
                    || strpos($key, 'shadow_image_') === 0
                    || strpos($key, 'highlight_image_') === 0
                    || strpos($key, 'preview_image_') === 0
                    || strpos($key, 'file_') === 0;
            }, ARRAY_FILTER_USE_KEY);

            // Group file fields by their index
            $modelGroups = [];
            foreach ($fileFields as $key => $file) {
                if (preg_match('/_(\d+)$/', $key, $matches)) {
                    $index = $matches[1];
                    if (!isset($modelGroups[$index])) {
                        $modelGroups[$index] = [];
                    }
                    $modelGroups[$index][$key] = $file;
                }
            }
            dd($modelGroups);
            // Process each model group
            foreach ($modelGroups as $index => $files) {
                $templateModel = new TemplateModels();
                $templateModel->template_id = $template->id;

                // Handle image files
                $imageTypes = ['background_image', 'shadow_image', 'highlight_image', 'preview_image'];
                foreach ($imageTypes as $imageType) {
                    $fileKey = "{$imageType}_{$index}";
                    if (isset($files[$fileKey])) {
                        $file = $files[$fileKey];
                        $filePath = $file->store("template/{$template->id}/{$index}", 'public');
                        $templateModel->$imageType = $filePath;
                    }
                }

                // Handle foreground image if needed
                $foregroundKey = "foreground_image_{$index}";
                if (isset($files[$foregroundKey])) {
                    $file = $files[$foregroundKey];
                    $filePath = $file->store("template/{$template->id}/{$index}", 'public');
                    $templateModel->foreground_image = $filePath;
                }

                // Handle additional files dynamically
                $filePaths = [];
                foreach ($files as $key => $file) {
                    if (preg_match('/^file_(\d+)_(\d+)$/', $key, $matches)) {
                        $filePath = $file->store("template/{$template->id}/{$index}", 'public');
                        $filePaths[] = $filePath;
                    }
                }

                // Store the additional files as a comma-separated list in the model_image field
                $templateModel->model_image = implode(',', $filePaths);
                
                // Save TemplateModel
                $templateModel->save();
            }

            return redirect()->route('template.index')->with('success', 'Template created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Templates::with('templateModels')->findOrFail($id);
        $templateFiles = $template->templateModels[0]->model_image;
        dd($template);
        dd($templateFiles);
        $categories = Category::all();
        $users = User::all();

        return view('admin.template.edit', compact('template', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Templates $template)
    {
        $template->delete();
        return response()->json([
            'success' => true,
            'message' => "Template has been deleted successfully",
            'data' => [],
        ]);
    }

    public function getSubCategories($categoryId)
    {
        $subCategories = Category::where('is_deleted', false)->where('parent_id', $categoryId)->pluck('name', '_id');
        return response()->json($subCategories);
    }

    public function getNoOfFiles($categoryId)
    {
        $noOfFiles = Category::findOrFail($categoryId)->no_of_user_input;
        return response()->json($noOfFiles);
    }
}
