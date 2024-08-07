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
            $subCategory = Templates::all();
            return DataTables::of($subCategory)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-sub-category" data-action="' . route('sub-category.show', $row->id) . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-sub-category" data-original-title="Delete" data-action="' . route('sub-category.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
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
        ]);

        if ($validator->fails()) {
            // dd($validator->fails());        
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            $data['status'] = 1;
            $template = Templates::create($data);

            // Handle predefined file types
            $fileTypes = ['background_image', 'foreground_image', 'shadow_image', 'highlight_image', 'preview_image'];
            foreach ($fileTypes as $type) {
                $inputName = "{$type}_1"; // Assuming _1 is the index for these files
                if ($request->hasFile($inputName)) {
                    $path = $this->handleFileUpload($request->file($inputName), $template->id, $type, 1);

                    TemplateModels::create([
                        'template_id' => $template->id,
                        "{$type}_image" => $path
                    ]);
                }
            }

            // Handle additional dynamic files
            $fileCount = $request->input('no_of_files', 0);
            for ($i = 0; $i < $fileCount; $i++) {
                foreach ($fileTypes as $type) {
                    $inputName = "{$type}_{$i}";
                    if ($request->hasFile($inputName)) {
                        $path = $this->handleFileUpload($request->file($inputName), $template->id, $type, $i);

                        TemplateModels::create([
                            'template_id' => $template->id,
                            "{$type}_image" => $path
                        ]);
                    }
                }
            }
            return redirect()->route('template.index')->with('success', 'Template created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    function handleFileUpload($file, $templateId, $type, $index)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitizedFileName = Str::slug($fileName, '_');
        $timestamp = Carbon::now()->timestamp;
        $folderPath = "template/template_{$sanitizedFileName}";
        $filename = "{$type}_{$templateId}_{$timestamp}_{$index}.{$file->getClientOriginalExtension()}";
        $path = $file->storeAs($folderPath, $filename, 'public');

        return $path;
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
        //
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
    public function destroy(string $id)
    {
        //
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
