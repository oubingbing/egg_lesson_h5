<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CommonReturn
{
    /**
     * 统一处理返回格式
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response instanceof ApiException){
            return $response;
        }

        if ($response instanceof JsonResponse) {
            $response = $this->json($response);
        }elseif ($response instanceof \Exception){
            $response = $this->exception($response);
        }elseif (!$response->original instanceof View){
            $response = $this->noneView($response);
        }

        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        return $response;
    }

    /**
     * 处理json返回数据
     *
     * @author yezi
     * @param $response
     * @return mixed
     */
    private function json($response)
    {
        $tempVal = collect($response->original)->toArray();
        if(isset($tempVal['code'])){
            return $response;
        }

        $message = [
            'code'    => 0,
            'message' => 'success',
        ];
        return $this->dealWithResponse($response,$message);
    }

    /**
     * 处理非类型数据
     *
     * @author yezi
     * @param $response
     * @return mixed
     */
    private function noneView($response)
    {
        $message = [
            'code'    => 0,
            'message' => 'success',
        ];

        $factoryResponse =  response()->json([],200, ['Content-Type' => 'application/json; charset=UTF-8'])->setEncodingOptions(JSON_UNESCAPED_UNICODE);;
        $factoryResponse->setData($response->original);
        $response = $factoryResponse;
        return $this->dealWithResponse($response,$message);
    }

    /**
     * 处理异常
     *
     * @author yezi
     * @param $response
     * @return mixed
     */
    private function exception($response)
    {
        $message = [
            'code'    => $response->getCode(),
            'message' => $response->getMessage(),
        ];

        $factoryResponse = app(JsonResponse::class);
        $factoryResponse->setData('null');
        $response = $factoryResponse;

        return $this->dealWithResponse($response,$message);
    }

    /**
     * 设置返回数据
     *
     * @author yezi
     * @param $response
     * @param $message
     * @return mixed
     */
    private function dealWithResponse($response,$message)
    {
        $oriData = $response->getData();
        $data['data'] = ($oriData->data ?? []) ? $oriData->data : $oriData;

        if ($oriData->current_page ?? '') {
            $data['meta'] = [
                'total'        => $oriData->total ?? 0,
                'per_page'     => (int)$oriData->per_page ?? 0,
                'current_page' => $oriData->current_page ?? 0,
                'last_page'    => $oriData->last_page ?? 0
            ];
        }

        if ($oriData->meta ?? '') {
            $data['meta'] = [
                'total'        => $oriData->meta->total ?? 0,
                'per_page'     => (int)$oriData->meta->per_page ?? 0,
                'current_page' => $oriData->meta->current_page ?? 0,
                'last_page'    => $oriData->meta->last_page ?? 0
            ];
        }

        $temp = ($oriData) ? array_merge($message, $data) : $message;

        if(!isset($temp['data'])){
            $temp['data'] = '';
        }

        $temp['json_api'] = [
            'copy_right'=>'EGG_LESSON',
            'version'=>'1.0'
        ];

        $response = $response->setData($temp);

        return $response;
    }
}
