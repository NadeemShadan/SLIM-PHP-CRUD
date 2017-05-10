<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
$app->get('/api/customers',function(Request $request,Response $response){
$sql="SELECT * FROM customer";
// connect
try {
  $db=new db();
  $db=$db->connect();
  $stmt=$db->query($sql);
  $customers=$stmt->fetchAll(PDO::FETCH_OBJ);
  $db=null;
  echo json_encode($customers);
} catch (PDOException $e) {
  echo '{"error":{"text":'.$e->getMessage().'}';
}
});
//single customer
$app->get('/api/customer/{id}',function(Request $request,Response $response){
  $id=$request->getAttribute('id');
$sql="SELECT * FROM customer WHERE id=$id";
// connect
try {
  $db=new db();
  $db=$db->connect();
  $stmt=$db->query($sql);
  $customer=$stmt->fetchAll(PDO::FETCH_OBJ);
  $db=null;
  echo json_encode($customer);
} catch (PDOException $e) {
  echo '{"error":{"text":'.$e->getMessage().'}';
}
});
// insert a customer
$app->post('/api/customer/add',function(Request $request,Response $response){
  $first_name=$request->getParam('first_name');
  $last_name=$request->getParam('last_name');
  $phone=$request->getParam('phone');
  $adress=$request->getParam('adress');
  $email=$request->getParam('email');
  $city=$request->getParam('city');
  $street=$request->getParam('street');
$sql="INSERT INTO customer (first_name,last_name,phone,adress,email,city,street) VALUES(:first_name,:last_name,:phone,:adress,:email,:city,:street)";
// connect
try {
  $db=new db();
  $db=$db->connect();
  $stmt=$db->prepare($sql);
  $stmt->bindParam(':first_name',$first_name);
  $stmt->bindParam(':last_name',$last_name);
  $stmt->bindParam(':phone',$phone);
  $stmt->bindParam(':adress',$adress);
  $stmt->bindParam(':email',$email);
  $stmt->bindParam(':city',$city);
  $stmt->bindParam(':street',$street);
  $stmt->execute();
  echo '{"notice":{"text":"customer Added"}';
} catch (PDOException $e) {
  echo '{"error":{"text":'.$e->getMessage().'}';
}
});
// update customer
$app->put('/api/customer/edit/{id}',function(Request $request,Response $response){
  $id=$request->getAttribute('id');
  $first_name=$request->getParam('first_name');
  $last_name=$request->getParam('last_name');
  $phone=$request->getParam('phone');
  $adress=$request->getParam('adress');
  $email=$request->getParam('email');
  $city=$request->getParam('city');
  $street=$request->getParam('street');
$sql="UPDATE customer SET
                           first_name=:first_name,
                           last_name=:last_name,
                           phone=:phone,
                           adress=:adress,
                           email=:email,
                           city=:city,
                           street=:street WHERE id=$id";
// connect
try {
  $db=new db();
  $db=$db->connect();
  $stmt=$db->prepare($sql);
  $stmt->bindParam(':first_name',$first_name);
  $stmt->bindParam(':last_name',$last_name);
  $stmt->bindParam(':phone',$phone);
  $stmt->bindParam(':adress',$adress);
  $stmt->bindParam(':email',$email);
  $stmt->bindParam(':city',$city);
  $stmt->bindParam(':street',$street);
  $stmt->execute();
  echo '{"notice":{"text":"customer Data Edited"}';
} catch (PDOException $e) {
  echo '{"error":{"text":'.$e->getMessage().'}';
}
});
// delete customer
$app->delete('/api/customer/delete/{id}',function(Request $request,Response $response){
$id=$request->getAttribute('id');
$sql="DELETE FROM customer WHERE id=$id";
// connect
try {
  $db=new db();
  $db=$db->connect();
  $stmt=$db->prepare($sql);
  $stmt->execute();
  $db=null;
  echo '{"notice":{"text":"customer Removed"}';
} catch (PDOException $e) {
  echo '{"error":{"text":'.$e->getMessage().'}';
}
});
