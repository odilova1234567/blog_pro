<?php

namespace App\Http\Controllers;

use App\Models\ApiUser;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiUserController extends Controller
{
      //
       /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"ApiUser API"},
     *     summary="Register",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="phone", type="string", example="998902017747"),
     *              @OA\Property(property="fullname", type="string", example="O'g'iloy"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and added new task",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example=null
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Qo'shildi",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function register(Request $request){
        if(strlen($request->password) < 6){
            return $this->sendResponse(null,false,"Parol kamida 6 belgidan iborat bo'lsin!");
        }

        ApiUser::create([
            'phone'=>$request->phone,
            'fullname'=>$request->fullname,
            'password'=>Hash::make($request->password),
        ]);
        return $this->sendResponse(null,true,"Qo'shildi");
    }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"ApiUser API"},
     *     summary="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="phone", type="string", example="998902017747"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *          ),
     *     ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and added new task",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example= {
     *                          "id": 11,
     *                          "phone": "998902017747",
     *                          "fullname": "O'g'iloy",
     *                          "token": "htg387htv73gw3yg8v9g8yrfg923f4",
     *                          "password": "$2y$12$lkQctPgpsD2bYXkgHPJLt.DLpAJwjS.uXlCpc8Bt39pGv4G8tcNTK",
     *                          "created_at": "2023-08-29T04:39:24.000000Z",
     *                          "updated_at": null
     *          }
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Xush Kelibsiz!",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function login(Request $request){
        $ApiUser_find = ApiUser::where('phone',$request->phone)->first();
        if($ApiUser_find == null){
            return $this->sendResponse(null,false,"ApiUser topilmadi!");
        }
        if(!Hash::check( $request->password,$ApiUser_find->password)){
            return $this->sendResponse(null,false,"Parol Xato!");
        }
        $token = Str::random(30);
        $ApiUser_find->update([
            'token'=>$token
        ]);
        $ApiUser_find = ApiUser::where('phone',$request->phone)->first();
        return $this->sendResponse($ApiUser_find,true,"Xush Kelibsiz!");
    }
    /**
     * @OA\Get(
     *     path="/api/get",
     *     tags={"ApiUser API"},
     *     summary="GetAppUser",
     *   @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and added new task",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                          "id": 11,
     *                          "phone": "998902017747",
     *                          "fullname": "O'g'iloy",
     *                          "token": "htg387htv73gw3yg8v9g8yrfg923f4",
     *                          "password": "$2y$12$lkQctPgpsD2bYXkgHPJLt.DLpAJwjS.uXlCpc8Bt39pGv4G8tcNTK",
     *                          "created_at": "2023-08-29T04:39:24.000000Z",
     *                          "updated_at": null
     *          }
     *
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function getApiUser(Request $request){
        $check_ApiUser = $request->check_ApiUser;
        return $this->sendResponse($check_ApiUser,true,"");

    }
    /**
     * @OA\Get(
     *     path="/api/list",
     *     tags={"ApiUser API"},
     *     summary="GetUserlist",
     *   @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and added new task",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example={
     *                         {
     *                          "id": 11,
     *                          "phone": "998902017747",
     *                          "fullname": "O'g'iloy",
     *                          "token": "htg@htg387htv73gw3yg8v9g#%@8yr3f4",
     *                          "password": "$2y$12$lkQctPgpsD2bYXkgHPJLt.DLpAJwjS.uXlCpc8Bt39pGv4G8tcNTK",
     *                          "created_at": "2023-08-29T04:39:24.000000Z",
     *                          "updated_at": null
     *                          },
     * {
     *                          "id": 7,
     *                          "phone": "998902017747",
     *                          "fullname": "O'g'iloy",
     *                          "token": "htg387htv73^%@gw3yg#$%^28v9g8yrfg9",
     *                          "password": "$2y$12$lkQctPgpsD2bYXkgHPJLt.DLpAJwjS.uXlCpc8Bt39pGv4G8tcNTK",
     *                          "created_at": "2023-08-29T04:39:24.000000Z",
     *                          "updated_at": null
     *                          },}
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Here is your list",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function list(){


        $headers = getallheaders();
        $token = isset($headers['Token']) ? $headers['Token'] : "";
        $post_all = Post::all();
        if(empty($token) ){
            return $this->sendResponse($post_all,true,"");
        }else{
            $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
            $post = Post::where("user_id",$check_ApiUser->id)->get();
        if($check_ApiUser == null){
            return $this->sendResponse(null,false,"User topilmadi");
        }else{
            return $this->sendResponse($post,true,"");
        }
        }


    }
    /**
         * @OA\Post(
         *     path="/api/create",
         *     tags={"ApiUser API"},
         *     summary="Add AppUser",
         *     @OA\Parameter(
         *         name="Token",
         *         in="header",
         *         description="User token",
         *         @OA\Schema(
         *             type="string"
         *         )
         *     ),
         *     @OA\RequestBody(
         *              @OA\MediaType(
         *                       mediaType="multipart/form-data",
         *                       @OA\Schema(
         *                           @OA\Property(
         *                               property="image",
         *                               type="file",
         *                               format="file"
         *                           ),
         *              @OA\Property(property="content", type="string", example="Content"),
         *              @OA\Property(property="title", type="string", example="Title"),
         *                       )
         *                  ),
         *     ),
         *     @OA\Response(
         *     response="200",
         *     description="Add AppUser.",
         *     @OA\JsonContent(
         *              type="object",
         *              @OA\Property(
         *                  format="boolean",
         *                  default="true",
         *                  description="success",
         *                  property="success"
         *              ),
         *              @OA\Property(
         *                  type="object",
         *                  description="data",
         *                  property="data",
         *                  example="null",
         *              ),
         *              @OA\Property(
         *                  format="string",
         *                  default="Qo'shildi!",
         *                  description="message",
         *                  property="message"
         *              ),
         *              @OA\Property(
         *                  format="integer",
         *                  default="0",
         *                  description="error_code",
         *                  property="error_code"
         *              ),
         *          ),
         *     ),
         * )
         */
    public function add(Request $request){
        $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
        if($check_ApiUser == null){
            return $this->sendResponse(null,false,"User topilmadi");
        }
        $image = $request->file('image');

        $image_name = Str::random(20);
        $ext = strtolower($image->getClientOriginalExtension()); // You can use also getClientOriginalName()
        $image_full_name = $image_name . '.' . $ext;
        $upload_path = 'upload';
        $save_url_image = $upload_path . $image_full_name;
        $success = $image->move($upload_path, $image_full_name);
        Post::create([
            "image" => $save_url_image,
            "title" => $request->title,
            "content" => $request->content,
            "user_id" => $check_ApiUser->id,
        ]);
        return $this->sendResponse(null,true,"Qo'shildi");

    }
     /**
         * @OA\Post(
         *     path="/api/update/{id}",
         *     tags={"ApiUser API"},
         *     summary="Update AppUser",
         *     @OA\Parameter(
         *         name="Token",
         *         in="header",
         *         description="User token",
         *         @OA\Schema(
         *             type="string"
         *         )
         *     ),
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         description="Post id",
         *         @OA\Schema(
         *             type="string"
         *         )
         *     ),
         *     @OA\RequestBody(
         *              @OA\MediaType(
         *                       mediaType="multipart/form-data",
         *                       @OA\Schema(
         *                           @OA\Property(
         *                               property="image",
         *                               type="file",
         *                               format="file"
         *                           ),
         *              @OA\Property(property="content", type="string", example="Content"),
         *              @OA\Property(property="title", type="string", example="Title"),
         *                       )
         *                  ),
         *     ),
         *     @OA\Response(
         *     response="200",
         *     description="Add AppUser.",
         *     @OA\JsonContent(
         *              type="object",
         *              @OA\Property(
         *                  format="boolean",
         *                  default="true",
         *                  description="success",
         *                  property="success"
         *              ),
         *              @OA\Property(
         *                  type="object",
         *                  description="data",
         *                  property="data",
         *                  example="null",
         *              ),
         *              @OA\Property(
         *                  format="string",
         *                  default="O'zgartirildi!",
         *                  description="message",
         *                  property="message"
         *              ),
         *              @OA\Property(
         *                  format="integer",
         *                  default="0",
         *                  description="error_code",
         *                  property="error_code"
         *              ),
         *          ),
         *     ),
         * )
         */
    public function news(Request $request,$id){
        $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
        if($check_ApiUser == null){
            return $this->sendResponse(null,false,"User topilmadi");
        }
        $user = Post::find($id);
        if(!$user){
            return $this->sendResponse(null,false,"Post topilmadi");
        }else{
            if($user->user_id !== $check_ApiUser->id){
                return $this->sendResponse(null,false,"Post sizniki emas");
            }else{

        $image = $request->file('image');

        $image_name = Str::random(20);
        $ext = strtolower($image->getClientOriginalExtension()); // You can use also getClientOriginalName()
        $image_full_name = $image_name . '.' . $ext;
        $upload_path = 'upload';
        $save_url_image = $upload_path . $image_full_name;
        $success = $image->move($upload_path, $image_full_name);
                 $user->update([
            "image" => $save_url_image,
            "title" => $request->title,
            "content" => $request->content,
            "user_id" => $check_ApiUser->id,
        ]);
            }

        }
        return $this->sendResponse(null,true,"O'zgartirildi!");
    }
        /**
     * @OA\Delete(
     *     path="/api/delete/{id}",
     *     tags={"ApiUser API"},
     *     summary="Delete post",
     *   @OA\Parameter(
     *           name="Token",
     *           in="header",
     *           description="User token",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id",
     *          required=true,
     *       ),
     *     @OA\Response(
     *     response="200",
     *     description="Check user **token** and delete this task",
     *     @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="object",
     *                  description="data",
     *                  property="data",
     *                  example=null
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="O'chirildi",
     *                  description="message",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  format="integer",
     *                  default="0",
     *                  description="error_code",
     *                  property="error_code"
     *              ),
     *          ),
     *     ),
     * )
     */
    public function destroy($id){
        $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
        if($check_ApiUser == null){
            return $this->sendResponse(null,false,"User topilmadi");
        }
        $user = Post::find($id);
        if(!$user){
            return $this->sendResponse(null,false,"Post topilmadi");
        }else{
            $user = Post::find($id);
            $check_ApiUser = ApiUser::where("token",$this->getToken())->first();
            if($user->user_id !== $check_ApiUser->id){
                return $this->sendResponse(null,false,"Post sizniki emas");
            }else{
                $user->delete();
            }

        }
        return $this->sendResponse(null,true,"O'chirildi!");
    }

}
