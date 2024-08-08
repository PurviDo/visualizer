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
            $subCategory = Templates::with(['category', 'subCategory'])->get();
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
        // dd($request->all());
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

            $templateId = $template->id;

            // Handle dynamic rows for template models
            $modelIndex = 0;
            while ($request->has("background_image_$modelIndex")) {

                $templateModel = TemplateModels::create(['template_id' => $templateId]);
                $modelData = [
                    'background_image' => $this->storeFile($request->file("background_image_$modelIndex"), $templateId, $templateModel->id,'background_image'),
                    'foreground_image' => $this->storeFile($request->file("foreground_image_$modelIndex"), $templateId, $templateModel->id,'foreground_image'),
                    'shadow_image' => $this->storeFile($request->file("shadow_image_$modelIndex"), $templateId, $templateModel->id,'shadow_image'),
                    'highlight_image' => $this->storeFile($request->file("highlight_image_$modelIndex"), $templateId, $templateModel->id,'highlight_image'),
                    'preview_image' => $this->storeFile($request->file("preview_image_$modelIndex"), $templateId, $templateModel->id,'preview_image'),
                    'model_image' => $this->storeFiles($request->file("file_$modelIndex"), $templateId, $templateModel->id,'model_image'),
                ];
                $templateModel->update($modelData);
                $modelIndex++;
            }
            return redirect()->route('template.index')->with('success', 'Template created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    private function storeFile($file, $templateId, $index, $name)
    {
        if ($file) {
            $path = public_path("templates/$templateId/$index");

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $timestamp = now()->format('YmdHis');
            // $filename = $file->getClientOriginalName();
            $filename = $name."_".$timestamp;
            $file->move($path, $name."_".$timestamp);
            return "templates/$templateId/$index/$filename";
        }
        return null;
    }

    private function storeFiles($files, $templateId, $index, $name)
    {
        $filePaths = [];

        if ($files) {
            foreach ($files as $file) {
                $filePaths[] = $this->storeFile($file, $templateId, $index, $name);
            }
        }

        return implode(',', $filePaths);
    }


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

        $categories = Category::where('is_deleted', false)->where('parent_id', null)->get();
        $subCategories = Category::where('parent_id', $template->category_id)->get();

        $users = User::all();

        return view('admin.template.edit', compact('template', 'categories', 'users', 'subCategories'));
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