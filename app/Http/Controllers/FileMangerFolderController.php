<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveFolder;
use App\Http\Resources\ListFolders;
use App\Models\FileManagerFolder;
use Illuminate\Http\JsonResponse;
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
    }

    public function trash(): JsonResponse
    {
        $directories = FileManagerFolder::onlyTrashed()->where('parent_id', null)->get();
        return $this->respond(
            [
                'directories' => ListFolders::make($directories)
            ]
        );
    }

    public function store(SaveFolder $request): JsonResponse
    {
        try {
            FileManagerFolder::createFolder(name: $request->name, slug: $request->slug, parentId: $request->parent_id);
            return $this->successMessage("فولدر با موفقیت ساخته شد");
        } catch (\Exception $e) {
            return $this->respondExceptionError($e);
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
    }

    public function update(SaveFolder $request): JsonResponse
    {
        FileManagerFolder::updateFolder(name: $request->name, slug: $request->slug, id: $request->id);
        return $this->successMessage("فولدر با موفقیت ویرایش گردید");
    }

    public function delete($folderId): JsonResponse
    {
        FileManagerFolder::findOrFail($folderId)->delete();
        return $this->successMessage("فولدر با موفقیت حذف گردید");
    }

    public function restore($id): JsonResponse
    {

        $folder = FileManagerFolder::withTrashed()->find($id);
        $folder->restore();

        return $this->successMessage("فولدر با موفقیت برگردانده گردید");

    }
}
