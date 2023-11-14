<?php

namespace App\Http\Resources\Produtos\Cartao;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CooperadoComLimiteEBloqueioCollection extends ResourceCollection
{
    public $collects = CooperadoComLimiteEBloqueioResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Http\Response
     * @return void
     */

     public function withResponse($request, $response)
     {
         $response->setStatusCode(200);
     }

     /**
      * Bootstrap any application services.
      *
      * @return void
      */
     public function boot()
     {
         JsonResource::withoutWrapping();
     }
}
