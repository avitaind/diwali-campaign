<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Faker\Provider\Image;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\DiwaliCampaign;

class DiwaliCampaignController extends Controller
{

    /*
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response

     */

    public function upload($file)
    {
        if (is_null($file)) {

            return storage_path() . '/uploads/' . '1.png';

        }
        else {
            if ($file->isValid()) {
                $fileName = (new \DateTime())->format('d.m.Y-hsi').'.'.$file->guessExtension();
                $file->move(storage_path() . '/uploads', $fileName);
                return storage_path() . '/uploads/' . $fileName;
            } else {
                return \Redirect::route('contact_show')
                    ->with('message', 'The File is not valid!');
            }
        }
    }
    public function diwaliCampaign()
    {
        return view('diwali-campaign');
    }
    /*
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function diwaliSaveData(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone'=>'required',
            'address1' => 'required',
            'address2' => 'required',
            'pin'=>'required',
            'invoice_no'=>'required',
            'invoice_image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'model_no'=>'required'
        ]);
        $filePath = $this->upload($request->file('invoice_image'));

        DiwaliCampaign::create($request->all());

        \Mail::send('emails.diwalicampaign',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address1' => $request->get('address1'),
                'address2' => $request->get('address2'),
                'pin' => $request->get('pin'),
                'invoice_no' => $request->get('invoice_no'),
                'invoice_image' => $filePath,
                'model_no' => $request->get('model_no'),

            ), function ($message) use ($request)
            {
                $message->from('avitaind@gmail.com');
                $message->to('avitaind@gmail.com', 'Admin')->subject('Diwali Campaign');
    });

	    //return redirect()->back()->with('success', 'Thank you for your submission . You shall receive a confirmation mail shortly');
        return redirect()->back()->with('message', 'Thank you for your submission . You shall receive a confirmation mail shortly');

}

}


