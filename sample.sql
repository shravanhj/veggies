-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2023 at 06:06 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `Address_id` int(11) NOT NULL,
  `Customer_id` int(3) NOT NULL,
  `Address_line_1` varchar(50) NOT NULL,
  `Address_line_2` varchar(50) NOT NULL,
  `Area` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Pincode` int(6) NOT NULL,
  `State` varchar(9) NOT NULL,
  `Country` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_id` int(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone_No` bigint(13) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_id`, `Name`, `Email`, `Phone_No`, `Password`) VALUES
(100, 'Demo', 'demo@demo', 740692844, '89e495e7941cf9e40e6980d14a16bf023ccd4c91');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Cart_id` int(3) NOT NULL,
  `Customer_id` int(3) NOT NULL,
  `Product_id` int(10) NOT NULL,
  `Product_Name` varchar(20) NOT NULL,
  `Category` varchar(10) NOT NULL,
  `MRP` int(5) NOT NULL,
  `Selling_Price` int(5) NOT NULL,
  `Quantity` int(3) NOT NULL DEFAULT 1,
  `Image_01` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Customer_id` int(3) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone` bigint(13) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Address_line_1` varchar(50) NOT NULL,
  `Address_line_2` varchar(50) NOT NULL,
  `Area` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Pincode` int(6) NOT NULL,
  `State` varchar(9) NOT NULL DEFAULT 'KARNATAKA',
  `Country` varchar(5) NOT NULL DEFAULT 'INDIA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Customer_id`, `Name`, `Email`, `Phone`, `Password`, `Address_line_1`, `Address_line_2`, `Area`, `City`, `Pincode`, `State`, `Country`) VALUES
(100, 'Demo', 'demo@demo', 123456789, '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 'abcd', 'xyz', 'asdf', 'qw', 123, 'KARNATAKA', 'INDIA');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_id` int(10) NOT NULL,
  `Product_id` int(3) NOT NULL,
  `Image_01` varchar(50) NOT NULL,
  `Customer_id` int(3) NOT NULL,
  `Product_name` varchar(20) NOT NULL,
  `Quantity` int(2) NOT NULL,
  `Total_Price` int(6) NOT NULL,
  `Address_line_1` varchar(50) NOT NULL,
  `Address_line_2` varchar(50) NOT NULL,
  `Area` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `Pincode` int(5) NOT NULL,
  `State` varchar(9) NOT NULL,
  `Country` varchar(5) NOT NULL,
  `Order_Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `Payment_Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `order_time` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Product_id` int(10) NOT NULL,
  `Product_Name` varchar(30) NOT NULL,
  `Category` varchar(11) NOT NULL,
  `Selling_Price` int(5) NOT NULL,
  `MRP` int(5) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Stock` int(3) NOT NULL,
  `Image_01` varchar(50) NOT NULL,
  `Seller` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_id`, `Product_Name`, `Category`, `Selling_Price`, `MRP`, `Description`, `Stock`, `Image_01`, `Seller`) VALUES
(1001, 'Potato (1 kg)', 'Vegetables', 27, 39, 'Potato is a very good source of fiber, which is helping us in losing weight.\r\nFiber can help to prevent heart disease and maintaining cholesterol and blood sugar levels.\r\nIt also has antioxidants which are very helpful in preventing diseases\r\nContains vitamins that will help our body to properly function.', 10, 'potato.png', 0),
(1002, 'Desi Tomato (1 kg)', 'Vegetables', 220, 290, 'Tomatoes are a good source of fiber, Vitamins, and minerals like Vitamin C, Potassium, Vitamin K1, Folate (vitamin B9).\r\nHelp to prevent heart attacks.\r\nPreventing cancer.\r\nBeneficial for skin health.', 10, 'tomato.png', 0),
(1003, 'Onion (1 kg)', 'Vegetables', 26, 35, 'Onions are a good source of Vitamin C, Vitamin B6, Manganese.\r\nIt contains antioxidants that help to fight inflammation.\r\nDecrease triglycerides.\r\nReduce cholesterol levels which may lower heart disease risk of the body.\r\nContains cancer-fighting compound’s, control blood sugar.', 10, 'onion.png', 0),
(1004, 'Green Chilly (250gm)', 'Vegetables', 15, 25, 'Green Chilly is widely used in cooking as it’s great for a healthy diet containing zero calories.\r\nRich in vitamin C and beta-carotene which Improve our skin.\r\nThe perfect cure for a stressful mind.\r\nLower our body temperature as it contains Capsaicin.\r\nNatural source of iron which help in not feel tired or week.\r\nBalance blood sugar levels.\r\nImprove our immune system.\r\nAct as a Pain reliever, digestive, and ulcer preventative as it contains plenty of fibers.\r\nReduce atherosclerosis.\r\nReducing b', 5, 'green-pepper.png', 0),
(1005, 'Cucumber(500 GM)', 'Vegetables', 20, 28, 'Cucumber is high in Nutrients as it contains important vitamins and minerals like Vitamin C, Vitamin K, Magnesium, Potassium, Manganese.\r\nIt Contains Antioxidants that block oxidation in our body.\r\nHelp in Weight Loss.\r\nLower Blood Sugar level.\r\nCucumbers are high in water which promotes hydration.', 10, 'cucumber.png', 0),
(1006, 'Capsicum (250gm)', 'Vegetables', 9, 25, 'Capsicum is also known as Shimla Mirch. It’s sweet and tangy, which makes the green vegetables tend to taste more bitter.\r\nCapsicum found in different colors like Red capsicum, Yellow capsicum, Green capsicum, Orange capsicum, and Purple/Black capsicum. Red capsicums which contain more phytonutrients than other capsicums have the highest antioxidants content.\r\nIt has 11 times more beta-carotene, and one and a half times more vitamin C than green varieties.\r\nGreen capsicums contain less sugar tha', 10, 'green-pepper-2.png', 0),
(1007, 'Carrot Red(500gm)', 'Vegetables', 30, 40, 'Carrots are a good source of several vitamins and minerals, nutrients, such as fiber, potassium, vitamin C, manganese, vitamin A, and vitamin B.\r\nits plays a vital role in certain medical conditions, like metabolic syndrome and inflammatory intestinal conditions', 10, 'carrot.png', 0),
(1008, 'Green Chilly (250gm)', 'Vegetables', 15, 25, 'Act as a Pain reliever, digestive, and ulcer preventative as it contains plenty of fibers.\r\nReduce atherosclerosis.\r\nReducing blood cholesterol.\r\nPrevents blood clots save us from a heart attack or stroke', 5, 'red-chili.png', 0),
(2001, 'Strawberry (1 Pkt)', 'Fruits', 76, 110, 'Strawberry is one of the most popular fruit.\r\nIt is a good source of antioxidants and detoxifiers.\r\nStrawberry improves our heart function.\r\nUseful for pregnant women as it contains Folic acid which helps in preventing birth defects.\r\nKeep your wrinkles at bay.\r\nLower your cholesterol and ward off cancer.\r\nReduce arthritis and gout pain', 20, 'strawberry.png', 0),
(2002, 'Pomegranate (500gm)', 'Fruits', 80, 110, 'Pomegranate is a fruit which is commonly known as Anar that contains multiple edible seeds which is called arils.\r\nAnar is rich in fiber, vitamins, minerals However it also contains some sugar.\r\nIt has Impressive Anti-Inflammatory Effects.\r\nMay Help to Fight Prostate Cancer.\r\nLower Blood Pressure.\r\nFight with Arthritis and Joint Pain.\r\nLower Risk of Heart Disease.\r\nPomegranate Juice May Help Treat Erectile Dysfunction,\r\nPomegranate Can Help in Fight Bacterial and Fungal Infections,\r\nMay Help Imp', 20, 'pomegranate.png', 0),
(2003, 'Mango (1 Kg)', 'Fruits', 100, 140, 'Mango is known as the King of Fruits.\r\nIt is very delicious in taste with an impressive nutritional profile.\r\nHigh in Antioxidants.\r\nIt May Boost Immunity.\r\nIt May Support Heart Health.\r\nIt May Improve Digestive Health.\r\nIt May Support Eye Health.\r\nIt May Improve Hair and Skin Health.\r\nIt May Help Lower Your Risk of Cancers.', 10, 'mango.png', 0),
(2004, 'Apple (500 Gram)', 'Fruits', 130, 165, 'Apples are rich in Nutrition such as manganese, copper, vitamins A, E, B1, B2, and B6.\r\nApples may help in weight loss, reduce the risk of cancer, Lowering the Risk of Diabetes.\r\nIt can help in fighting Asthma, Good for Bone health, helps in protecting the brain.\r\nApple peels contain folic acid which is helping in increasing skeletal muscle & brown fat\r\nAlso decreases white fat, glucose intolerance, obesity, fatty liver disease.', 20, 'apple.png', 0),
(2005, 'Kiwi (500gm)', 'Fruits', 220, 250, 'Kiwi is a small fruit that has a lot of flavors and plenty of health benefits.\r\nCan help to treat asthma.\r\nIt Aids digestion as have plenty of fiber.\r\nBoosts the immune system.\r\nIt Can help manage blood pressure.\r\nMay reduce blood clotting.\r\nIt Protects against vision loss.', 10, 'kiwi.png', 0),
(2006, 'Pineapple (1 Pc 800g', 'Fruits', 112, 125, 'Pineapple is also known as Ananas which is incredibly delicious in taste and healthy tropical fruit.\r\nPineapples are packed with multiple vitamins and minerals, especially rich in vitamin C and manganese.\r\nIts have several benefits such as Loaded With Nutrients, Contains disease-fighting Antioxidants.\r\nIt contains bromelain Enzymes that Can Ease Digestion.\r\nReduce the Risk of Cancer.\r\nBoost Immunity and Suppress Inflammation.\r\nEase Symptoms of Arthritis.\r\nSpeed Recovery After Surgery or Strenuou', 10, 'pineapple.png', 0),
(2007, 'Red Grapes Imported(', 'Fruits', 425, 470, 'Grapes are rich in high nutrient and antioxidant contents.\r\nPacked With Nutrients, Especially Vitamins C and K.\r\nHigh Antioxidant Contents May Prevent Chronic Diseases.\r\nLower Blood Pressure.\r\nReduce Cholesterol.\r\nMay Decrease Blood Sugar Levels and Protect Against Diabetes.\r\nBeneficial for Eye Health.\r\nMay Improve Memory, Attention and Mood.\r\nContain Many Nutrients that Important for Bone Health.\r\nProtect from Bacteria, Viruses, and Yeast Infections.\r\nSlow Down Aging and Promote Longevity.\r\nPre', 5, 'grape.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`Address_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `Address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `Admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `Customer_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2011;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
