-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 07:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `icon_class` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `slug`, `description`, `icon_class`) VALUES
(1, 'Diabetic-Friendly', 'diabetic-friendly', 'Suitable for diabetics', 'fa-heartbeat'),
(2, 'Egg-Free', 'egg-free', 'Contains no eggs', 'fa-egg'),
(3, 'Gluten-Free', 'gluten-free', 'Contains no gluten', 'fa-bread-slice'),
(4, 'High-Protein', 'high-protein', 'High protein content', 'fa-dumbbell'),
(5, 'Keto', 'keto', 'Keto-friendly recipes', 'fa-bacon'),
(6, 'Lactose-Free', 'lactose-free', 'No lactose', 'fa-cheese'),
(7, 'No-Bake', 'no-bake', 'Requires no baking', 'fa-temperature-low'),
(8, 'Nut-Free', 'nut-free', 'Contains no nuts', 'fa-tree'),
(9, 'Organic', 'organic', 'Organic ingredients', 'fa-leaf'),
(10, 'Sugar-Free', 'sugar-free', 'No added sugar', 'fa-candy-cane'),
(11, 'Vegan', 'vegan', 'No animal products', 'fa-seedling'),
(12, 'Vegetarian', 'vegetarian', 'Vegetarian recipes', 'fa-carrot');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `prep_time` int(11) DEFAULT NULL,
  `cook_time` int(11) DEFAULT NULL,
  `servings` int(11) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') NOT NULL DEFAULT 'Easy',
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `steps` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `name`, `description`, `category`, `prep_time`, `cook_time`, `servings`, `difficulty`, `image`, `video`, `ingredients`, `steps`, `author`, `created_at`) VALUES
(1, 'Low-Sugar Apple Pie', 'A healthy take on classic apple pie.', 'Diabetic-Friendly', 30, 20, 6, 'Medium', 'diabetic_friendly_1.jpg', NULL, '{}', '{}', 'ChefA', '2025-04-19 21:04:49'),
(2, 'Sugar-Free Chocolate Cake', 'Rich and moist chocolate cake without sugar.', 'Diabetic-Friendly', 45, 30, 8, 'Hard', 'diabetic_friendly_2.jpg', NULL, '{}', '{}', 'ChefB', '2025-04-19 21:04:49'),
(3, 'Almond Flour Pancakes', 'Perfect pancakes without refined sugar.', 'Diabetic-Friendly', 20, 15, 4, 'Easy', 'diabetic_friendly_3.jpg', NULL, '{}', '{}', 'ChefC', '2025-04-19 21:04:49'),
(4, 'Keto Cheesecake', 'Delicious keto-friendly cheesecake.', 'Diabetic-Friendly', 50, 40, 8, 'Medium', 'diabetic_friendly_4.jpg', NULL, '{}', '{}', 'ChefD', '2025-04-19 21:04:49'),
(5, 'Berry Chia Pudding', 'Simple and tasty sugar-free chia pudding.', 'Diabetic-Friendly', 10, 0, 2, 'Easy', 'diabetic_friendly_5.jpg', NULL, '{}', '{}', 'ChefE', '2025-04-19 21:04:49'),
(6, 'Zucchini Brownies', 'Fudgy brownies made with zucchini.', 'Diabetic-Friendly', 35, 25, 6, 'Medium', 'diabetic_friendly_6.jpg', NULL, '{}', '{}', 'ChefF', '2025-04-19 21:04:49'),
(7, 'Coconut Macaroons', 'Low-carb coconut macaroons.', 'Diabetic-Friendly', 15, 10, 4, 'Easy', 'diabetic_friendly_7.jpg', NULL, '{}', '{}', 'ChefG', '2025-04-19 21:04:49'),
(8, 'Sugar-Free Lemon Bars', 'Refreshing lemon bars without sugar.', 'Diabetic-Friendly', 40, 20, 8, 'Medium', 'diabetic_friendly_8.jpg', NULL, '{}', '{}', 'ChefH', '2025-04-19 21:04:49'),
(9, 'Avocado Chocolate Mousse', 'Creamy chocolate dessert with avocado.', 'Diabetic-Friendly', 10, 0, 2, 'Easy', 'diabetic_friendly_9.jpg', NULL, '{}', '{}', 'ChefI', '2025-04-19 21:04:49'),
(10, 'Carrot Cake Energy Bites', 'Healthy carrot cake bites.', 'Diabetic-Friendly', 20, 0, 4, 'Easy', 'diabetic_friendly_10.jpg', NULL, '{}', '{}', 'ChefJ', '2025-04-19 21:04:49'),
(11, 'Coconut Milk Ice Cream', 'Dairy-free and delicious ice cream.', 'Dairy-Free', 40, 30, 6, 'Medium', 'dairy_free_1.jpg', NULL, '{}', '{}', 'ChefK', '2025-04-19 21:04:49'),
(12, 'Almond Yogurt Parfait', 'Perfect dairy-free breakfast parfait.', 'Dairy-Free', 15, 0, 2, 'Easy', 'dairy_free_2.jpg', NULL, '{}', '{}', 'ChefL', '2025-04-19 21:04:49'),
(13, 'Oat Milk Latte', 'Smooth dairy-free latte.', 'Dairy-Free', 5, 0, 1, 'Easy', 'dairy_free_3.jpg', NULL, '{}', '{}', 'ChefM', '2025-04-19 21:04:49'),
(14, 'Cashew Cheese Dip', 'Dairy-free cheesy dip.', 'Dairy-Free', 20, 0, 4, 'Easy', 'dairy_free_4.jpg', NULL, '{}', '{}', 'ChefN', '2025-04-19 21:04:49'),
(15, 'Chocolate Almond Smoothie', 'Rich dairy-free chocolate drink.', 'Dairy-Free', 10, 0, 1, 'Easy', 'dairy_free_5.jpg', NULL, '{}', '{}', 'ChefO', '2025-04-19 21:04:49'),
(16, 'Coconut Rice Pudding', 'Classic pudding made dairy-free.', 'Dairy-Free', 35, 20, 4, 'Medium', 'dairy_free_6.jpg', NULL, '{}', '{}', 'ChefP', '2025-04-19 21:04:49'),
(17, 'Peach Sorbet', 'Refreshing dairy-free peach dessert.', 'Dairy-Free', 20, 0, 4, 'Easy', 'dairy_free_7.jpg', NULL, '{}', '{}', 'ChefQ', '2025-04-19 21:04:49'),
(18, 'Vegan Chocolate Chip Cookies', 'Dairy-free classic cookies.', 'Dairy-Free', 25, 15, 6, 'Medium', 'dairy_free_8.jpg', NULL, '{}', '{}', 'ChefR', '2025-04-19 21:04:49'),
(19, 'Soy Milk Panna Cotta', 'Silky smooth dairy-free panna cotta.', 'Dairy-Free', 50, 30, 4, 'Hard', 'dairy_free_9.jpg', NULL, '{}', '{}', 'ChefS', '2025-04-19 21:04:49'),
(20, 'Banana Ice Cream', 'Super simple banana-only ice cream.', 'Dairy-Free', 10, 0, 2, 'Easy', 'dairy_free_10.jpg', NULL, '{}', '{}', 'ChefT', '2025-04-19 21:04:49'),
(21, 'Gluten-Free Chocolate Cake', 'Decadent chocolate cake without gluten.', 'Gluten-Free', 45, 30, 8, 'Hard', 'gluten_free_1.jpg', NULL, '{}', '{}', 'ChefA', '2025-04-19 21:04:49'),
(22, 'Quinoa Salad', 'Nutritious gluten-free quinoa salad.', 'Gluten-Free', 20, 0, 4, 'Easy', 'gluten_free_2.jpg', NULL, '{}', '{}', 'ChefB', '2025-04-19 21:04:49'),
(23, 'Almond Flour Bread', 'Fluffy bread made without gluten.', 'Gluten-Free', 50, 40, 6, 'Medium', 'gluten_free_3.jpg', NULL, '{}', '{}', 'ChefC', '2025-04-19 21:04:49'),
(24, 'Cauliflower Pizza Crust', 'Gluten-free pizza base.', 'Gluten-Free', 35, 20, 2, 'Medium', 'gluten_free_4.jpg', NULL, '{}', '{}', 'ChefD', '2025-04-19 21:04:49'),
(25, 'Rice Noodles Stir Fry', 'Quick and easy stir fry.', 'Gluten-Free', 15, 10, 2, 'Easy', 'gluten_free_5.jpg', NULL, '{}', '{}', 'ChefE', '2025-04-19 21:04:49'),
(26, 'Chickpea Flatbread', 'Simple gluten-free flatbread.', 'Gluten-Free', 25, 15, 4, 'Easy', 'gluten_free_6.jpg', NULL, '{}', '{}', 'ChefF', '2025-04-19 21:04:49'),
(27, 'Sweet Potato Brownies', 'Rich brownies with sweet potato.', 'Gluten-Free', 40, 25, 6, 'Medium', 'gluten_free_7.jpg', NULL, '{}', '{}', 'ChefG', '2025-04-19 21:04:49'),
(28, 'Gluten-Free Pancakes', 'Fluffy pancakes without gluten.', 'Gluten-Free', 20, 10, 4, 'Easy', 'gluten_free_8.jpg', NULL, '{}', '{}', 'ChefH', '2025-04-19 21:04:49'),
(29, 'Cornbread Muffins', 'Delicious gluten-free muffins.', 'Gluten-Free', 30, 20, 6, 'Medium', 'gluten_free_9.jpg', NULL, '{}', '{}', 'ChefI', '2025-04-19 21:04:49'),
(30, 'Fruit Salad with Honey', 'Simple healthy fruit salad.', 'Gluten-Free', 10, 0, 4, 'Easy', 'gluten_free_10.jpg', NULL, '{}', '{}', 'ChefJ', '2025-04-19 21:04:49'),
(31, 'Egg-Free Chocolate Cake', 'Rich chocolate cake without eggs.', 'Egg-Free', 45, 30, 8, 'Medium', 'egg_free_1.jpg', NULL, '{}', '{}', 'ChefA', '2025-04-19 21:10:18'),
(32, 'Banana Oat Pancakes', 'Healthy egg-free pancakes.', 'Egg-Free', 20, 10, 4, 'Easy', 'egg_free_2.jpg', NULL, '{}', '{}', 'ChefB', '2025-04-19 21:10:18'),
(33, 'Vegan Brownies', 'Fudgy brownies without eggs.', 'Egg-Free', 35, 25, 6, 'Medium', 'egg_free_3.jpg', NULL, '{}', '{}', 'ChefC', '2025-04-19 21:10:18'),
(34, 'Chia Seed Muffins', 'Fluffy muffins using chia seeds.', 'Egg-Free', 25, 20, 6, 'Easy', 'egg_free_4.jpg', NULL, '{}', '{}', 'ChefD', '2025-04-19 21:10:18'),
(35, 'Pumpkin Bread', 'Moist pumpkin bread without eggs.', 'Egg-Free', 50, 40, 8, 'Medium', 'egg_free_5.jpg', NULL, '{}', '{}', 'ChefE', '2025-04-19 21:10:18'),
(36, 'Vegan Banana Bread', 'Soft banana bread without eggs.', 'Egg-Free', 40, 30, 6, 'Easy', 'egg_free_6.jpg', NULL, '{}', '{}', 'ChefF', '2025-04-19 21:10:18'),
(37, 'Applesauce Muffins', 'Muffins with applesauce instead of eggs.', 'Egg-Free', 30, 20, 6, 'Easy', 'egg_free_7.jpg', NULL, '{}', '{}', 'ChefG', '2025-04-19 21:10:18'),
(38, 'Zucchini Chocolate Cake', 'Chocolate cake using zucchini.', 'Egg-Free', 45, 35, 8, 'Medium', 'egg_free_8.jpg', NULL, '{}', '{}', 'ChefH', '2025-04-19 21:10:18'),
(39, 'Peanut Butter Cookies', 'Classic egg-free cookies.', 'Egg-Free', 20, 10, 4, 'Easy', 'egg_free_9.jpg', NULL, '{}', '{}', 'ChefI', '2025-04-19 21:10:18'),
(40, 'Egg-Free Cupcakes', 'Light cupcakes without eggs.', 'Egg-Free', 25, 15, 6, 'Easy', 'egg_free_10.jpg', NULL, '{}', '{}', 'ChefJ', '2025-04-19 21:10:18'),
(41, 'Vegan Chocolate Mousse', 'Creamy vegan chocolate mousse.', 'Vegan', 15, 0, 2, 'Easy', 'vegan_1.jpg', NULL, '{}', '{}', 'ChefK', '2025-04-19 21:10:18'),
(42, 'Vegan Mac & Cheese', 'Delicious vegan mac and cheese.', 'Vegan', 30, 15, 4, 'Medium', 'vegan_2.jpg', NULL, '{}', '{}', 'ChefL', '2025-04-19 21:10:18'),
(43, 'Vegan Tacos', 'Spicy and flavorful vegan tacos.', 'Vegan', 20, 10, 3, 'Easy', 'vegan_3.jpg', NULL, '{}', '{}', 'ChefM', '2025-04-19 21:10:18'),
(44, 'Vegan Chocolate Cake', 'Rich vegan chocolate cake.', 'Vegan', 50, 35, 8, 'Hard', 'vegan_4.jpg', NULL, '{}', '{}', 'ChefN', '2025-04-19 21:10:18'),
(45, 'Vegan Smoothie Bowl', 'Colorful smoothie bowl.', 'Vegan', 10, 0, 2, 'Easy', 'vegan_5.jpg', NULL, '{}', '{}', 'ChefO', '2025-04-19 21:10:18'),
(46, 'Vegan Cheesecake', 'Dairy-free vegan cheesecake.', 'Vegan', 60, 0, 8, 'Hard', 'vegan_6.jpg', NULL, '{}', '{}', 'ChefP', '2025-04-19 21:10:18'),
(47, 'Vegan Brownies', 'Ultra fudgy vegan brownies.', 'Vegan', 40, 30, 6, 'Medium', 'vegan_7.jpg', NULL, '{}', '{}', 'ChefQ', '2025-04-19 21:10:18'),
(48, 'Vegan Burritos', 'Hearty vegan burritos.', 'Vegan', 25, 15, 4, 'Easy', 'vegan_8.jpg', NULL, '{}', '{}', 'ChefR', '2025-04-19 21:10:18'),
(49, 'Vegan Pancakes', 'Fluffy eggless vegan pancakes.', 'Vegan', 20, 10, 4, 'Easy', 'vegan_9.jpg', NULL, '{}', '{}', 'ChefS', '2025-04-19 21:10:18'),
(50, 'Vegan Ice Cream', 'Rich creamy vegan ice cream.', 'Vegan', 30, 0, 4, 'Medium', 'vegan_10.jpg', NULL, '{}', '{}', 'ChefT', '2025-04-19 21:10:18'),
(51, 'Nut-Free Chocolate Cookies', 'Chocolate cookies without nuts.', 'Nut-Free', 25, 15, 6, 'Easy', 'nut_free_1.jpg', NULL, '{}', '{}', 'ChefA', '2025-04-19 21:10:18'),
(52, 'Oatmeal Raisin Cookies', 'Delicious nut-free cookies.', 'Nut-Free', 20, 10, 4, 'Easy', 'nut_free_2.jpg', NULL, '{}', '{}', 'ChefB', '2025-04-19 21:10:18'),
(53, 'Sunflower Seed Butter Cups', 'Nut-free butter cups.', 'Nut-Free', 30, 10, 4, 'Medium', 'nut_free_3.jpg', NULL, '{}', '{}', 'ChefC', '2025-04-19 21:10:18'),
(54, 'Nut-Free Granola Bars', 'Healthy nut-free bars.', 'Nut-Free', 20, 10, 4, 'Easy', 'nut_free_4.jpg', NULL, '{}', '{}', 'ChefD', '2025-04-19 21:10:18'),
(55, 'Nut-Free Banana Muffins', 'Banana muffins without nuts.', 'Nut-Free', 30, 20, 6, 'Medium', 'nut_free_5.jpg', NULL, '{}', '{}', 'ChefE', '2025-04-19 21:10:18'),
(56, 'Coconut Energy Balls', 'Nut-free energy balls.', 'Nut-Free', 15, 0, 4, 'Easy', 'nut_free_6.jpg', NULL, '{}', '{}', 'ChefF', '2025-04-19 21:10:18'),
(57, 'Cinnamon Apple Crisp', 'Crispy apple dessert.', 'Nut-Free', 40, 30, 6, 'Medium', 'nut_free_7.jpg', NULL, '{}', '{}', 'ChefG', '2025-04-19 21:10:18'),
(58, 'Chocolate Chip Muffins', 'Nut-free chocolate muffins.', 'Nut-Free', 25, 15, 6, 'Medium', 'nut_free_8.jpg', NULL, '{}', '{}', 'ChefH', '2025-04-19 21:10:18'),
(59, 'Nut-Free Carrot Cake', 'Carrot cake without nuts.', 'Nut-Free', 45, 30, 8, 'Hard', 'nut_free_9.jpg', NULL, '{}', '{}', 'ChefI', '2025-04-19 21:10:18'),
(60, 'Nut-Free Snack Mix', 'Healthy nut-free snack mix.', 'Nut-Free', 10, 0, 4, 'Easy', 'nut_free_10.jpg', NULL, '{}', '{}', 'ChefJ', '2025-04-19 21:10:18'),
(61, 'Sugar-Free Brownies', 'Delicious brownies without sugar.', 'Sugar-Free', 35, 25, 6, 'Medium', 'sugar_free_1.jpg', NULL, '{}', '{}', 'ChefK', '2025-04-19 21:10:18'),
(62, 'Sugar-Free Cheesecake', 'Creamy cheesecake without sugar.', 'Sugar-Free', 50, 30, 8, 'Hard', 'sugar_free_2.jpg', NULL, '{}', '{}', 'ChefL', '2025-04-19 21:10:18'),
(63, 'No-Sugar Oatmeal', 'Simple no-sugar oatmeal.', 'Sugar-Free', 15, 0, 2, 'Easy', 'sugar_free_3.jpg', NULL, '{}', '{}', 'ChefM', '2025-04-19 21:10:18'),
(64, 'Sugar-Free Muffins', 'Muffins sweetened naturally.', 'Sugar-Free', 25, 20, 6, 'Medium', 'sugar_free_4.jpg', NULL, '{}', '{}', 'ChefN', '2025-04-19 21:10:18'),
(65, 'Sugar-Free Chocolate Pudding', 'Rich pudding without sugar.', 'Sugar-Free', 20, 10, 4, 'Easy', 'sugar_free_5.jpg', NULL, '{}', '{}', 'ChefO', '2025-04-19 21:10:18'),
(66, 'Sugar-Free Lemon Cake', 'Lemon cake without added sugar.', 'Sugar-Free', 45, 30, 8, 'Medium', 'sugar_free_6.jpg', NULL, '{}', '{}', 'ChefP', '2025-04-19 21:10:18'),
(67, 'Sugar-Free Apple Crisp', 'Naturally sweetened apple dessert.', 'Sugar-Free', 35, 25, 6, 'Medium', 'sugar_free_7.jpg', NULL, '{}', '{}', 'ChefQ', '2025-04-19 21:10:18'),
(68, 'No Sugar Peanut Butter Balls', 'Healthy peanut butter snack.', 'Sugar-Free', 15, 0, 4, 'Easy', 'sugar_free_8.jpg', NULL, '{}', '{}', 'ChefR', '2025-04-19 21:10:18'),
(69, 'Sugar-Free Berry Smoothie', 'Refreshing smoothie.', 'Sugar-Free', 10, 0, 2, 'Easy', 'sugar_free_9.jpg', NULL, '{}', '{}', 'ChefS', '2025-04-19 21:10:18'),
(70, 'Sugar-Free Chocolate Fudge', 'Rich fudge without sugar.', 'Sugar-Free', 30, 20, 4, 'Medium', 'sugar_free_10.jpg', NULL, '{}', '{}', 'ChefT', '2025-04-19 21:10:18'),
(71, 'Protein Pancakes', 'High-protein fluffy pancakes.', 'High-Protein', 20, 10, 2, 'Easy', 'high_protein_1.jpg', NULL, '{}', '{}', 'ChefA', '2025-04-19 21:10:18'),
(72, 'Protein Mug Cake', 'Quick protein-packed dessert.', 'High-Protein', 10, 1, 1, 'Easy', 'high_protein_2.jpg', NULL, '{}', '{}', 'ChefB', '2025-04-19 21:10:18'),
(73, 'Chicken Salad', 'Protein-rich salad.', 'High-Protein', 15, 0, 2, 'Easy', 'high_protein_3.jpg', NULL, '{}', '{}', 'ChefC', '2025-04-19 21:10:18'),
(74, 'Protein Brownies', 'Delicious high-protein brownies.', 'High-Protein', 30, 20, 6, 'Medium', 'high_protein_4.jpg', NULL, '{}', '{}', 'ChefD', '2025-04-19 21:10:18'),
(75, 'Protein Smoothie', 'High-protein fruit smoothie.', 'High-Protein', 10, 0, 2, 'Easy', 'high_protein_5.jpg', NULL, '{}', '{}', 'ChefE', '2025-04-19 21:10:18'),
(76, 'Turkey Lettuce Wraps', 'Low-carb protein wraps.', 'High-Protein', 20, 0, 2, 'Easy', 'high_protein_6.jpg', NULL, '{}', '{}', 'ChefF', '2025-04-19 21:10:18'),
(77, 'Beef Stir Fry', 'Quick protein-rich dinner.', 'High-Protein', 25, 15, 4, 'Medium', 'high_protein_7.jpg', NULL, '{}', '{}', 'ChefG', '2025-04-19 21:10:18'),
(78, 'High-Protein Waffles', 'Fluffy waffles with extra protein.', 'High-Protein', 25, 10, 4, 'Easy', 'high_protein_8.jpg', NULL, '{}', '{}', 'ChefH', '2025-04-19 21:10:18'),
(79, 'Protein Overnight Oats', 'Simple high-protein breakfast.', 'High-Protein', 5, 0, 2, 'Easy', 'high_protein_9.jpg', NULL, '{}', '{}', 'ChefI', '2025-04-19 21:10:18'),
(80, 'Salmon Bowl', 'Healthy protein-packed salmon bowl.', 'High-Protein', 30, 20, 2, 'Medium', 'high_protein_10.jpg', NULL, '{}', '{}', 'ChefJ', '2025-04-19 21:10:18'),
(81, 'No-Bake Cheesecake', 'Creamy no-bake cheesecake.', 'No-Bake', 20, 0, 6, 'Easy', 'no_bake_1.jpg', NULL, '{}', '{}', 'ChefK', '2025-04-19 21:10:18'),
(82, 'No-Bake Chocolate Oat Bars', 'Delicious no-bake chocolate bars.', 'No-Bake', 15, 0, 6, 'Easy', 'no_bake_2.jpg', NULL, '{}', '{}', 'ChefL', '2025-04-19 21:10:18'),
(83, 'No-Bake Peanut Butter Cookies', 'Quick peanut butter cookies.', 'No-Bake', 10, 0, 4, 'Easy', 'no_bake_3.jpg', NULL, '{}', '{}', 'ChefM', '2025-04-19 21:10:18'),
(84, 'No-Bake Energy Bites', 'Healthy snack bites.', 'No-Bake', 15, 0, 4, 'Easy', 'no_bake_4.jpg', NULL, '{}', '{}', 'ChefN', '2025-04-19 21:10:18'),
(85, 'No-Bake Brownies', 'Rich no-bake brownies.', 'No-Bake', 20, 0, 6, 'Medium', 'no_bake_5.jpg', NULL, '{}', '{}', 'ChefO', '2025-04-19 21:10:18'),
(86, 'No-Bake Apple Crisp', 'Easy apple crisp without baking.', 'No-Bake', 20, 0, 4, 'Easy', 'no_bake_6.jpg', NULL, '{}', '{}', 'ChefP', '2025-04-19 21:10:18'),
(87, 'No-Bake Pumpkin Pie', 'Pumpkin dessert without oven.', 'No-Bake', 30, 0, 6, 'Medium', 'no_bake_7.jpg', NULL, '{}', '{}', 'ChefQ', '2025-04-19 21:10:18'),
(88, 'No-Bake Vegan Bars', 'Healthy vegan dessert.', 'No-Bake', 25, 0, 4, 'Easy', 'no_bake_8.jpg', NULL, '{}', '{}', 'ChefR', '2025-04-19 21:10:18'),
(89, 'No-Bake Lemon Squares', 'Refreshing lemon bars.', 'No-Bake', 15, 0, 4, 'Easy', 'no_bake_9.jpg', NULL, '{}', '{}', 'ChefS', '2025-04-19 21:10:18'),
(90, 'No-Bake Coconut Cookies', 'Chewy coconut cookies.', 'No-Bake', 10, 0, 4, 'Easy', 'no_bake_10.jpg', NULL, '{}', '{}', 'ChefT', '2025-04-19 21:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prep_time` int(11) DEFAULT NULL COMMENT 'in minutes',
  `cook_time` int(11) DEFAULT NULL COMMENT 'in minutes',
  `servings` int(11) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_categories`
--

CREATE TABLE `recipe_categories` (
  `recipe_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_media`
--

CREATE TABLE `recipe_media` (
  `media_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `media_type` enum('image','video') NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `step_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `step_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'images/default.png',
  `bio` varchar(270) DEFAULT 'No bio yet',
  `hobbies` varchar(150) DEFAULT 'Still looking for new hobbies...',
  `Userrole` varchar(8) DEFAULT 'Baker'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `profile_picture`, `bio`, `hobbies`, `Userrole`) VALUES
(1, 'JohnDoe', 'johndoe@example.com', '$2y$10$Wzu0lGfMCn9CGmd7Ewh0VeHq3IAc561c3APcXW9kNlDTqNVViRKF6', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(2, 'MiraKamal', 'mirakamal@example.com', '$2y$10$EO6/Edr0FJlQwL/LJpqmue/e8QyuB1uL64.HgNotFWnNLTg4TTTla', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(3, 'rim', 'rim.serhan@lau.edu', '$2y$10$1ZDuNU6QPaq16P0jCyJFquCVc5vpPE39VAbD4fIPih/u9Fc9WhFQG', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rated_user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`recipe_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `idx_favorites_user` (`user_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `idx_recipes_user` (`user_id`);

--
-- Indexes for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD PRIMARY KEY (`recipe_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `recipe_media`
--
ALTER TABLE `recipe_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `idx_reviews_recipe` (`recipe_id`),
  ADD KEY `idx_reviews_user` (`user_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_user_ratings_rated_user` (`rated_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipe_media`
--
ALTER TABLE `recipe_media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD CONSTRAINT `recipe_categories_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_media`
--
ALTER TABLE `recipe_media`
  ADD CONSTRAINT `recipe_media_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`rated_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
