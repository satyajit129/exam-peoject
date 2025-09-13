<?php 

namespace App\Services;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionCategoryService
{
    public function renderCategoryList()
    {
        $categories = QuestionCategory::with('parent')->latest()->get();
        return view('teacher.pages.question_category_list', compact('categories'));
    }

    public function renderCategoryForm($id = null)
    {
        $category = $id ? QuestionCategory::findOrFail($id) : null;
        $parents = QuestionCategory::where('status','active')->where('id','!=',$id)->get();
        return view('teacher.pages.question_category_form', compact('category','parents'));
    }

    public function handleCategorySave(Request $request, $id = null)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:question_categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $category = $id ? QuestionCategory::findOrFail($id) : new QuestionCategory();
        $category->name = $validated['name'];
        $category->parent_id = $validated['parent_id'] ?? null;
        $category->status = $validated['status'];
        $category->save();

        return redirect()->route('questionCategoryList')->with('success','Category saved successfully.');
    }

    public function handleCategoryDelete($id)
    {
        $category = QuestionCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('questionCategoryList')->with('success','Category deleted successfully.');
    }
}
