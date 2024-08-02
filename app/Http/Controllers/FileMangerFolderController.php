<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveFolder;
use App\Http\Resources\ListFolders;
use App\Models\FileManagerFolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="FileManager API Document",
 *     description="FileManager API Document",
 *     @OA\Contact(
 *         email="daniyalx77@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Your License",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class FileMangerFolderController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="دریافت لیست کاربران",
     *     tags={"folders"},
     *     @OA\Response(response=200, description="عملیات موفقیت‌آمیز"),
     *     @OA\Response(response=400, description="درخواست نامعتبر")
     * )
     */
    public function index(): JsonResponse
    {
        $directories = FileManagerFolder::where('parent_id', null)->get();
        return $this->respond(
            [
                'directories' => ListFolders::make($directories)
            ]
        );
//        $parent_id = null;
//        $media = null;
//        return view('welcome', compact('directories', 'parent_id', 'media'));
    }

    public function store(SaveFolder $request): JsonResponse
    {
        try {
            FileManagerFolder::createFolder(name: $request->name, slug: $request->slug, parentId: $request->parent_id);
            return $this->successMessage("فولدر با موفقیت ساخته شد");
        } catch (\Exception $e) {
            return $this->errorMessage("فولدر ساخته نشد");

        }
    }

    public function show($slug): JsonResponse
    {
        $parent = FileManagerFolder::where('slug', $slug)->with('media', 'children', 'parent')->first();
        $breadcrumbs = $parent->getBreadcrumb();
        return $this->respond(
            [
                'directory'   => ListFolders::make($parent),
                'breadcrumbs' => $breadcrumbs
            ]
        );
//
//        $parent_id = $parent->id;
//        $directories = $parent->children;
//        $media = $parent->media;
//        return view('welcome', compact('media', 'parent', 'parent_id', 'directories', 'breadcrumbs'));
    }

    public function rename(SaveFolder $request): JsonResponse
    {
        FileManagerFolder::updateFolder(name: $request->name, slug: $request->slug, id: $request->id);
        return $this->successMessage("فولدر با موفقیت ویرایش گردید");
    }

    public function delete(Request $request): JsonResponse
    {
        FileManagerFolder::findOrFail($request->id)->delete();
        return $this->successMessage("فولدر با موفقیت حذف گردید");
    }


}
