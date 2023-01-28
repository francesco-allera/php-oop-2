<?php
/*
Creare uno shop online.
Strutturare le classi gestendo l'ereditarietà dove necessario.
Provare a far interagire tra di loro gli oggetti (es: l'utente dello shop inserisce una carta di credito)

Gestire le eccezioni (es: carta di credito scaduta)
*/

class Shop {
    private $name;
    private $website;

    public function __construct(string $name, string $website)
    {
        $this->name = $name;
        $this->website = $website;
    }

    // Getters
    public function getName() {
        return $this->name;
    }
    public function getWebsite() {
        return $this->website;
    }
}

class Product {
    private $name;
    private $seller;
    private $price;
    private $warrantyYears = 2;
    protected $shippingCost = 3.99;
    protected $shippingDays = 5;

    public function __construct(string $name, string $seller, float $price)
    {
        $this->name = $name;
        $this->seller = $seller;
        $this->price = $price;
    }

    // Getters
    public function getName() {
        return $this->name;
    }
    public function getSeller() {
        return $this->seller;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getWarrantyYears() {
        return $this->warrantyYears;
    }
    public function getShippingCost() {
        return $this->shippingCost;
    }
    public function getShippingDays() {
        return $this->shippingDays;
    }

    // Setters
    public function setPrice(float $price) {
        if ($price > 0.2)
            $this->price = $price;
    }
    public function setShippingCost(float $shippingCost) {
        $this->shippingCost = $shippingCost;
    }
    public function setShippingDays(int $shippingDays) {
        $this->shippingDays = $shippingDays;
    }
}

class Book extends Product {
    private $author;
    private $pages;
    private $genre;

    public function newBook(string $author, int $pages, string $genre)
    {
        $this->author = $author;
        $this->pages = $pages;
        $this->genre = $genre;
    }

    // Getters
    public function getAuthor() {
        return $this->author;
    }
    public function getPages() {
        return $this->pages;
    }
    public function getGenre() {
        return $this->genre;
    }
}

class Tech extends Product {
    private $screen;
    private $processor;
    private $memoryInGB;
    private $typology;

    public function newTech(float $screen, string $processor, int $memoryInGB, string $typology)
    {
        $this->screen = $screen;
        $this->processor = $processor;
        $this->memoryInGB = $memoryInGB;
        $this->typology = $typology;
    }

    // Getters
    public function getScreen() {
        return $this->screen;
    }
    public function getProcessor() {
        return $this->processor;
    }
    public function getMemory() {
        return $this->memoryInGB;
    }
    public function getTypology() {
        return $this->typology;
    }
}

class User {
    private $name;
    private $surname;
    private $email;
    private $password;
    private $birthDate;
    private $creditCard;
    private $cart = [];
    protected $discount = false;
    protected $annualCost = 0;

    public function __construct(string $name, string $surname, string $email, string $password, string $birthDate)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->birthDate = $birthDate;
    }

    // Getters
    public function getName() {
        return $this->name;
    }
    public function getSurname() {
        return $this->surname;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getBirthDate() {
        return $this->birthDate;
    }
    public function getCreditCard() {
        return $this->creditCard;
    }
    public function getCart() {
        return $this->cart;
    }

    // Setters
    public function setPassword(string $oldPassword, string $newPassword) {
        if ($this->password !== $oldPassword)
            throw new Exception('Wrong old password');
        elseif ($oldPassword === $newPassword)
            throw new Exception('Old and new password can\'t be the same');
        elseif (strlen($newPassword) < 8)
            throw new Exception('New password not secure enough');
        else
            $this->password = $newPassword;
    }
    public function setCreditCard(CreditCard $creditCard) {
        if ($this->creditCard === $creditCard)
            throw new Exception('Old and new credit card are the same');
        else
            $this->creditCard = $creditCard;
    }
    public function setProduct($product) {
        if (!$product instanceof Product)
            throw new Exception('Product not valid');
        else
            $this->cart[] = $product;
    }
}

class PrimeUser extends User {
    protected $discount = true;
    protected $annualCost = 39.99;

    public function setProduct($product) {
        if (!$product instanceof Product) {
            throw new Exception('Product not valid');
        } else {
            $product->setShippingCost(0.0);
            $product->setShippingDays(1);
            $this->cart[] = $product;
        }
    }
}

class CreditCard {
    private $number;
    private $expireYear;
    private $cvv;
    private $bank;

    public function __construct(int $number, int $expireYear, int $cvv, string $bank)
    {
        if ($expireYear < date("Y")) throw new Exception('Card expired');

        $this->number = $number;
        $this->expireYear = $expireYear;
        $this->cvv = $cvv;
        $this->bank = $bank;
    }

    // Getters
    public function getNumber() {
        return $this->number;
    }
    public function getExpireYear() {
        return $this->expireYear;
    }
    public function getCvv() {
        return $this->cvv;
    }
    public function getBank() {
        return $this->bank;
    }
}


$myShop = new Shop('Bool-mazon', 'www.boolmazon.com');
var_dump($myShop);

$tech1 = new Tech('mediapad', 'lenovo', 399.99);
$tech1->newTech(15.6, 'i5-12000', 1024, 'laptop');
var_dump($tech1);

$book1 = new Book('divina commedia', 'feltrinelli', 12.99);
$book1->newBook('Dante Alighieri', 356, 'poesia');
var_dump($book1);

$user1 = new User('Sabrina', 'Boh', 'boh@mail', '123456789', '1995-04-06');
var_dump($user1);

try {
    $cc1 = new CreditCard(123456789, 2022, 333, 'Fineco');
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage();
}

if ($cc1) {
    $user1->setCreditCard($cc1);
    var_dump($user1);
}

$user2 = new PrimeUser('Francesco', 'Allera', 'mmh@mail', 'abcdefghilm', '1991-03-03');
var_dump($user2);

try {
    $cc2 = new CreditCard(123456789, 2022, 567, 'Unicredit');
} catch (Exception $e) {
    echo 'Exception: '.$e->getMessage();
}

if ($cc2) {
    $user2->setCreditCard($cc2);
    var_dump($user2);
}

$user1->setProduct($book1);
$user1->setProduct($tech1);
var_dump($user1);

$user2->setProduct($book1);
$user2->setProduct($tech1);
var_dump($user2);

try {
    $user2->setPassword('abcdefghilm', 1234567890123456);
} catch (Exception $e) {
    echo 'Exception: '.$e->getMessage();
}
echo '----------------------------<br>';
var_dump($user2);