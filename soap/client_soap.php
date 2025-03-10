<?php

$client = new SoapClient(null, array(
    'location' => "http://localhost/DAW/soap/soap.php",
    'uri' => "http://localhost/DAW/soap/soap.php",
    'trace' => 1
));

try{
    //Crear un producto
    echo $client->createProduct("Producto 1", "Descripcion del Producto 1", 19.99);
    
    //Obtener productos
    print_r($client->getProducts());
    
    //Actualizar un producto 
    echo $client->updateProduct(1, "Producto 1 Actualizado", "Descripcion del Producto 1 actualizada", 29.99);
    
    //Eliminar un producto
    echo $client->deleteProduct(1);
} catch (SoapFault $e) {
    echo "Error:".$e->getMessage();
}
?>