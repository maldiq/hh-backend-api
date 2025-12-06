<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Like;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Person",
 *     description="Person recommendation, like, dislike API"
 * )
 */
class PersonController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/people",
     *     summary="List people",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="location",
     *         in="query",
     *         description="Filter by location",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="min_age",
     *         in="query",
     *         description="Minimum age",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $req)
    {
        $perPage = $req->get('per_page', 10);
        $query = Person::with('pictures')
            ->orderBy('created_at','desc');

        // Optional: apply location/age filters if requested
        if ($req->filled('location')) {
            $query->where('location', $req->location);
        }
        if ($req->filled('min_age')) {
            $query->where('age', '>=', (int)$req->min_age);
        }

        $people = $query->paginate($perPage);

        // append likes count
        $people->getCollection()->transform(function($p){
            $p->likes_count = $p->likes()->where('is_like', true)->count();
            return $p;
        });

        return response()->json($people);
    }

    /**
     * @OA\Post(
     *     path="/api/people/{person}/like",
     *     summary="Like a person",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Liked")
     * )
     */
    public function like(Request $req, Person $person)
    {
        // if you have auth: $userId = auth()->id();
        $userId = $req->input('user_id'); // or null
        // store like (we simply insert new record; to avoid duplicates add unique constraint or upsert)
        Like::create([
            'person_id' => $person->id,
            'user_id' => $userId,
            'is_like' => true
        ]);

        return response()->json(['message'=>'liked','likes_count' => $person->likes()->where('is_like', true)->count()]);
    }

    /**
     * @OA\Post(
     *     path="/api/people/{person}/dislike",
     *     summary="Dislike a person",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Disliked")
     * )
     */
    public function dislike(Request $req, Person $person)
    {
        $userId = $req->input('user_id');
        Like::create([
            'person_id' => $person->id,
            'user_id' => $userId,
            'is_like' => false
        ]);
        return response()->json(['message'=>'disliked']);
    }

    /**
     * @OA\Get(
     *     path="/api/people/{person}/liked-list",
     *     summary="List users who liked this person",
     *     tags={"Person"},
     *     @OA\Parameter(
     *         name="person",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function likedList(Person $person)
    {
        // return only liked records (if you store user info)
        $liked = $person->likes()->where('is_like', true)->get(['id','user_id','created_at']);
        return response()->json($liked);
    }
}
