<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Product</title>

    <style>
                h2{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 30px;
            padding-bottom: -20px;
        }
        p{
            font-family: Arial, Helvetica, sans-serif;
        }
        input{
            padding-top: -20px;
            margin-top: -20px;
            height: 40px;
            width: 250px;
            cursor: text;
            border: none;
        }
        input:hover{
            border: 1px dashed rgb(39, 39, 212);
        }
        .addProduct{
            background-color: rgb(194, 194, 194);
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 20px;
            margin: auto;
            width: 25%;
            padding-left: 10px;
            align-content: center;
            border-radius: 10px;
        }
        .submit {
            margin-top: 10px;
            width: 250px;
            height: 40px;
            display: inline-block;
            padding: 10px 15px;
            background-color: rgb(39, 39, 212);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .submit:hover{
            background-color: rgba(255, 255, 255, 0.692);
            color: black;
            border: 2px solid rgb(39, 39, 212);
        }
    </style>

</head>
<body>
    <div class="addProduct" >
        <h2>ADD NEW PRODUCT HERE</h2>
        <form action="{{route('products.store')}}" method="POST">
            {{ csrf_field() }}
            <p>Barcode</p>
            <input type="text" name="barcode" id="barcode" placeholder="Barcode" required><br>
            <p>Item Name</p>
            <input type="text" name="item_name" id="item_name"placeholder="Item Name" required><br>
            <p>Quantity</p>
            <input type="text" name="quantity" id="quantity" placeholder="Quantity" required><br>
            <p>Price</p>
            <input type="text" name="price" id="price" placeholder="Price" required><br>
            <input class="submit" type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>