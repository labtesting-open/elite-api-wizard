<?php

namespace Elitesports;

use stdClass;

class Tag
{
    private $tag;   
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->tag = new \Elitelib\Tag($host->getParams());  
        $this->respuestas = new Respuestas();      
        $this->token = new Token();       
    }


    public function checkTokenAndReturnResponse($json)
    {
        return $this->token->checkAndReturnResponseInBody($json);
    }


    public function get($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(           
            'language_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

        $tagsArray =  $this->tag->get($paramsNormaliced['language_code']);

        $someArray = array(); 
        foreach ($tagsArray as $key => $value) {

            $tag = $value['tag'];
            $name =$value['name'];
            $someArray[$tag] = $name;
        }    

        return $this->respuestas->standarSuccess($someArray);      

    }


    public function add($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $paramsReceived = json_decode($json, true);

        if(!empty($paramsReceived['tag']) && 
        !empty($paramsReceived['language_code']) &&
        !empty($paramsReceived['name']))
        {
            $affected = $this->tag->add(
                $paramsReceived['tag'],
                $paramsReceived['language_code'],
                $paramsReceived['name']
            );

            if ($affected > 0) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error409();
            }

        }

        return $responseHttp;

    }
    
    
    public function addList($list)
    {                     
           
        $affected = $this->tag->addList($list);

        if ($affected > 0) {                
            $responseHttp = $this->respuestas->customResult('ok', $affected, null);
        } else {
            $responseHttp = $this->respuestas->error409();
        }       

        return $responseHttp;

    }
   


    public function update($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $paramsReceived = json_decode($json, true);

        if(!empty($paramsReceived['tag']) || 
        !empty($paramsReceived['language_code']) ||
        !empty($paramsReceived['name']))
        {
            $affected = $this->tag->update(
                $paramsReceived['tag'],
                $paramsReceived['language_code'],
                $paramsReceived['name']
            );

            if ($affected > 0) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error409();
            }

        }

        return $responseHttp;
    }


    public function delete($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $paramsReceived = json_decode($json, true);

        if(!empty($paramsReceived['tag']) || 
        !empty($paramsReceived['language_code']))
        {
            $affected = $this->tag->delete(
                $paramsReceived['tag'],
                $paramsReceived['language_code']
            );

            if ($affected > 0) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error409();
            }

        }

        return $responseHttp;

    }   


}
