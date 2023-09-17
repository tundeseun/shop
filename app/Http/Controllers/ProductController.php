<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Helper\ProducerTest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
class ProductController extends Controller
{
    //
        /**

     * Write code on Method

     *

     * @return response()

     */

     public function index()

     {
 
         $products = Product::all();
 
         return view('products', compact('products'));
 
     }
     
   
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 

      public function create()
      {
          return view('product.create');
      }
      
      public function store(Request $request)
      {
          // Validation (you can customize validation rules as needed)
          $request->validate([
              'name' => 'required|max:255',
              'description' => 'required',
              'image' => 'required',
              'price' => 'required|numeric',
              
          ]);
      
          // Create a new product and save it to the database
          Product::create([
              'name' => $request->input('name'),
              'description' => $request->input('description'),
              'image' => $request->input('image'),
              'price' => $request->input('price'),
          ]);
        
          // Redirect back to the form with a success message
          return redirect('/product/create')->with('success', 'Product created successfully');
      }



      




     public function cart()
 
     {
 
         return view('cart');
 
     }
 
   
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function addToCart($id)
 
     {
 
         $product = Product::findOrFail($id);
 
           
 
         $cart = session()->get('cart', []);
 
   
 
         if(isset($cart[$id])) {
 
             $cart[$id]['quantity']++;
 
         } else {
 
             $cart[$id] = [
 
                 "name" => $product->name,
 
                 "quantity" => 1,
 
                 "price" => $product->price,
 
                 "image" => $product->image
 
             ];
 
         }
 
           
 
         session()->put('cart', $cart);

       // Create an instance of ProducerTest
$producerTest = new ProducerTest();

// Send the custom message
$messageToSend = 'Product added to cart successfully!';
$producerTest->sendMessage($messageToSend);


         return redirect()->back()->with('success', 'Product added to cart successfully!');
 
     }
 
   
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function update(Request $request)
 
     {
 
         if($request->id && $request->quantity){
 
             $cart = session()->get('cart');
 
             $cart[$request->id]["quantity"] = $request->quantity;
 
             session()->put('cart', $cart);
 
             session()->flash('success', 'Cart updated successfully');
 
         }
 
     }
 
   
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function remove(Request $request)
 
     {
 
         if($request->id) {
 
             $cart = session()->get('cart');
 
             if(isset($cart[$request->id])) {
 
                 unset($cart[$request->id]);
 
                 session()->put('cart', $cart);
 
             }
 
             session()->flash('success', 'Product removed successfully');
 
         }
 
     }
}
