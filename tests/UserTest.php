<?php

namespace App\tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase{
    
    
  public  function testCreateUser(){
    $createUser = [
        "email"    => "amit123@gmail.com",
        "phone"    => "s12345654321",
        "firstname"=> "string",
        "lastname" => "string"
        // "createdBy"=>"1"
    ];
    $client = static::createClient();
    $client->loginUser('amit@gmail.com');


    $response = static::createClient()->request('POST', '/api/users' , ['json' => $createUser]); 
    $this->assertResponseStatusCodeSame(201);  
  }

  public  function testGetCollectionUser(){

    $response = static::createClient()->request('GET', '/api/users'); 
    $this->assertResponseIsSuccessful();
  
  }

  public  function testGetItemUser(){

    $response = static::createClient()->request('GET', '/api/users/3'); 
    $this->assertResponseIsSuccessful();
  
  }

  public  function testUpdateUser(){
    $createUser = [
        "email" => "khanallama1@gmail.com",
    ];


    $response = static::createClient()->request('PUT', '/api/users/3' , ['json' => $createUser]); 
    $this->assertResponseStatusCodeSame(200);  
  }

  public  function testUpdatePatchUser(){
    $createUser = [
        "email" => "khanallama2@gmail.com",
    ];


    $response = static::createClient()->request('PATCH', '/api/users/3' , ['json' => $createUser]); 
    $this->assertResponseStatusCodeSame(200);  
  }
/**
 * @return
 */
  public  function testDeleteUser(){

    $response = static::createClient()->request('DELETE', '/api/users/4'); 
    $this->assertResponseIsSuccessful();
  
  }


}