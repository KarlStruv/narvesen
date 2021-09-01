<?php
//// Narvesen
// Preču katalogs,
// Pircējs,
// Iepirkšanās grozs,
// Iepērkoties Narvenā pircējam ir jābūt iespējais ielikt grozā 1 vai vairāk proces,
// Grozā var ielikt tik daudz preces, cik atrodas veikalā,
// Beigās ir iespēja veikt apmaksu par visu grozu.

function addProduct(string $name, int $price, int $quantity) : stdClass{

    $products = new stdClass();
    $products->name = $name;
    $products->price = $price;
    $products->quantity = $quantity;


    return $products;
}

$products = [
    addProduct("Loaf of bread", 120, 5),
    addProduct("Chocolate bar", 200, 3),
    addProduct("Breakfast cereal", 410, 1),
    addProduct("Chewing gum", 70, 10),
    addProduct("AR-15", 70000, 2),
];

$customer = new stdClass();
$customer -> name = "John";
$customer -> money = 5000;

$totalToPay = 0;
$cart = [];
$shopping = "yes";

while($shopping === "yes") {
    foreach ($products as $key => $product) {
        $price = $product->price / 100;

        echo "$key. $product->name  {$price}$  ($product->quantity)" . PHP_EOL;
    }



    $selection = (int)readline("Select a product: ");
    if($products[$selection]->quantity < 1){
        echo "Sorry, we don't have any left." . PHP_EOL;
        sleep(1);
    }
    else if (!isset($products[$selection])) {
        echo "Product not found!" . PHP_EOL;
        sleep(1);
    }
    else {
        $amountDecision = 0;
        while ($amountDecision < 1) {
            $quantity = (int)readline("Enter the amount: ");
            if ($quantity > $products[$selection]->quantity) {
                echo "Sorry! Don't have that many in the store." . PHP_EOL;
            } else {
                $amountDecision = 1;
            }
        }

        $selectedProduct = clone $products[$selection];
        $selectedProduct->quantity = $quantity;
        $cart[] = $selectedProduct;

        $products[$selection]->quantity -= $quantity;
        $total = 0;
        foreach ($cart as $product) {
            $total += $product->price * $product->quantity;
        }

        echo "Total for x$quantity $product->name: " . $total / 100 . "$" . PHP_EOL;

        $totalToPay += $total / 100;
    }

    $firstDecisionMade = 0;
    while($firstDecisionMade < 1) {

        $keepShopping = (string)readline("Continue shopping?(yes/no)");
        echo PHP_EOL;

        if ($keepShopping === "no") {
            $firstDecisionMade = 1;
            $shopping = false;
        }
        if ($keepShopping === "yes") {
            $firstDecisionMade = 1;
        }
    }


}
$secondDecisionMade = 0;
$balance = $customer->money / 100;
echo "Your balance is: {$balance}$" . PHP_EOL;
echo "Your total is: {$totalToPay}$" . PHP_EOL;
sleep(1);
echo "Beep." . PHP_EOL;
if($balance < $totalToPay){
    $toughDecision = readline("You do not have enough money! Take SMS Credit?(yes/no)");
    echo PHP_EOL;
    while ($secondDecisionMade < 1) {
        if ($toughDecision === "no") {
            echo "Ok, then put the products back and get out!" . PHP_EOL;
            $secondDecisionMade = 1;
        }
        if ($toughDecision === "yes") {
            echo "Good. Now pack your stuff and get out!" . PHP_EOL;
            $secondDecisionMade = 1;
        }
    }

}else{
    sleep(1);
    $remainingBalance = $customer->money / 100 - $totalToPay;
    echo "Your remaining balance is:  {$remainingBalance}$ " . PHP_EOL;
}













