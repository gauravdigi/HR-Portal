<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hiringportal;
use Illuminate\Support\Facades\Validator;   


class HiringController extends Controller
{

	public function store(Request $request)
	{
	    $validator = Validator::make($request->all(), [
		    'Title' => 'required|string|max:255',
		    'IsPaid' => 'required|boolean',
		    'SubscriptionStartDT' => 'nullable|date|required_if:IsPaid,true|before_or_equal:SubscriptionEndDT',
		    'SubscriptionEndDT' => 'nullable|date|required_if:IsPaid,true|after_or_equal:SubscriptionStartDT',
		    'Notes' => 'required|string|max:1000',
		], [
		    'SubscriptionStartDT.required_if' => 'The Valid From field is required.',
		    'SubscriptionEndDT.required_if' => 'The Valid To field is required.',
		], [
		    'SubscriptionStartDT' => 'Valid From',
		    'SubscriptionEndDT' => 'Valid To',
		]);


		if ($validator->fails()) {
		    return response()->json(['errors' => $validator->errors()], 422);
		}


	    $data = $request->only(['Title', 'IsPaid', 'SubscriptionStartDT', 'SubscriptionEndDT', 'Notes']);
	    $data['IsPaid'] = filter_var($request->input('IsPaid'), FILTER_VALIDATE_BOOLEAN);

	    if (!$data['IsPaid']) {
	        $data['SubscriptionStartDT'] = null;
	        $data['SubscriptionEndDT'] = null;
	    }

	    Hiringportal::create($data);

	    return response()->json(['success' => true, 'message' => 'Record added successfully.']);
	}


	public function index(Request $request)
	{
		$Hiringportal = Hiringportal::all();
		return view('hiringportal.index', compact('Hiringportal'));
	}
		public function update(Request $request, $id)
		{
		    $validated = $request->validate([
		        'Title' => 'required|string|max:255',
		        'IsPaid' => 'required|boolean',
		        'SubscriptionStartDT' => 'nullable|date|required_if:IsPaid,true|before_or_equal:SubscriptionEndDT',
		        'SubscriptionEndDT' => 'nullable|date|required_if:IsPaid,true|after_or_equal:SubscriptionStartDT',
		        'Notes' => 'required|string|max:1000',
		    ], [
		        'SubscriptionStartDT.required_if' => 'The Valid From field is required.',
		        'SubscriptionEndDT.required_if' => 'The Valid To field is required.',
		    ], [
		        'SubscriptionStartDT' => 'Valid From',
		        'SubscriptionEndDT' => 'Valid To',
		    ]);

		    $data = $request->only(['Title', 'IsPaid', 'SubscriptionStartDT', 'SubscriptionEndDT', 'Notes']);
		    $data['IsPaid'] = filter_var($request->input('IsPaid'), FILTER_VALIDATE_BOOLEAN);

		    // If IsPaid is false, clear the date fields
		    if (!$data['IsPaid']) {
		        $data['SubscriptionStartDT'] = null;
		        $data['SubscriptionEndDT'] = null;
		    }

		    $hiringportal = Hiringportal::findOrFail($id);
		    $hiringportal->update($data);

		    // Return JSON for AJAX
		    return response()->json([
		        'success' => true,
		        'message' => 'Record updated successfully.',
		    ]);
		}



	public function destroy($id)
	{
	    $hiringportal = Hiringportal::findOrFail($id);
	    $hiringportal->delete();

		return redirect()->route('hiringportal.index')->with(['success' => 'Record deleted successfully.', 'title' => 'Deleted']);

	}


}

?>