<?php namespace yourname\contentmanager\Controllers;

use Illuminate\Routing\Controller;
use yourname\contentmanager\Models\Content;
use Illuminate\Http\Request;

class ContentApiController extends Controller
{
    // Fetch all contents
    public function index() {
        return response()->json(Content::all(), 200);
    }

    // Fetch a single content
    public function show($id) {
        $content = Content::find($id);
        if ($content) {
            return response()->json($content, 200);
        }
        return response()->json(['message' => 'Content not found'], 404);
    }

    // Store new content
    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
        ]);
        $content = Content::create($validatedData);
        return response()->json($content, 201);
    }

    // Update content
    public function update(Request $request, $id) {
        $content = Content::find($id);
        if (!$content) {
            return response()->json(['message' => 'Content not found'], 404);
        }

        $content->update($request->all());
        return response()->json($content, 200);
    }

    // Delete content
    public function destroy($id) {
        $content = Content::find($id);
        if (!$content) {
            return response()->json(['message' => 'Content not found'], 404);
        }
        $content->delete();
        return response()->json(['message' => 'Content deleted'], 200);
    }
}