<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;


class BlogController extends Controller
{

    public function index(): JsonResponse
    {
        $blogs = Blog::query()->paginate(10);

        if ($blogs->isEmpty()) {

            return $this->getJsonResponse(null, "There Are No Blogs Found!");
        }

        return $this->getJsonResponse($blogs, "Blogs Fetched Successfully");
    }



    public function store(CreateBlogRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('images/blogs','public');

            $credentials['image'] = $path;
        }

        $blog = Blog::query()->create($credentials);

        return $this->getJsonResponse($blog, "Blog Created Successfully");
    }


    public function show(Blog $blog): JsonResponse
    {
        return $this->getJsonResponse($blog, "Blog Fetched Successfully");
    }


    public function update(UpdateBlogRequest $request, Blog $blog): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('images/blogs','public');

            $data['image'] = $path;
        }

        $blog->update($data);

        return $this->getJsonResponse($blog, "Blog Updated Successfully");
    }


    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return $this->getJsonResponse(null, "Blog Deleted Successfully");
    }
}
