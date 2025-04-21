-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 12:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `ingredients` text DEFAULT NULL,
  `steps` text DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `name`, `description`, `category`, `prep_time`, `cook_time`, `servings`, `difficulty`, `image`, `ingredients`, `steps`, `user`, `created_at`, `user_id`) VALUES
(95, 'Strawberry Cheesecake Bites', 'Delicious mini cheesecakes made with a low-carb almond flour base and topped with fresh strawberries — sugar-free and diabetic-safe!', 'Diabetic-Friendly', 25, 20, 12, 'Medium', 'Strawberry Cheesecake Bites.jpg', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Cream cheese, softened\",\"quantity\":\"200g\"},{\"ingredient\":\"Stevia or erythritol\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"},{\"ingredient\":\"Fresh strawberries\",\"quantity\":\"6 large, sliced\"}]', '[\"Preheat the oven to 350°F (175°C).\",\"Mix almond flour and melted butter, press into mini muffin molds to form a crust.\",\"Bake crusts for 5 minutes.\",\"Beat cream cheese, stevia, vanilla, and egg until smooth.\",\"Spoon the mixture over the crusts.\",\"Bake for 15 more minutes until set.\",\"Cool completely, then top with sliced strawberries before serving.\"]', 'Yassine zeort', '2025-04-20 21:09:36', 4),
(96, 'Low-Carb Lemon Bars', 'A bright, tangy dessert with a crisp almond flour crust and sugar-free lemon filling.', 'Diabetic-Friendly', 20, 30, 9, 'Medium', 'Low-Carb Lemon Bars.jpg', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"4\"},{\"ingredient\":\"Lemon juice\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Lemon zest\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Coconut flour\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix almond flour and butter; press into a lined baking pan.\",\"Bake crust for 10 minutes.\",\"Whisk eggs, stevia, lemon juice, lemon zest, and coconut flour together.\",\"Pour filling over crust and bake 20 minutes.\",\"Cool and refrigerate before cutting into bars.\"]', 'Yassine zeort', '2025-04-20 21:13:01', 4),
(97, 'Dark Chocolate Avocado Brownies', 'Rich, fudgy brownies made with avocado instead of butter, low in carbs and sugar-free.', 'Diabetic-Friendly', 15, 25, 8, 'Medium', 'Dark Chocolate Avocado Brownies.jpg', '[{\"ingredient\":\"Ripe avocados\",\"quantity\":\"2\"},{\"ingredient\":\"Cocoa powder (unsweetened)\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Blend avocados until smooth.\",\"In a bowl, combine avocado, cocoa, almond flour, stevia, eggs, baking powder, and vanilla.\",\"Pour into a greased baking dish.\",\"Bake for 20-25 minutes until set.\",\"Cool before slicing.\"]', 'Yassine zeort', '2025-04-20 21:13:56', 4),
(98, 'Baked Cinnamon Apple Slices', 'A simple, naturally sweetened dessert with warm cinnamon flavors, perfect for diabetics.', 'Diabetic-Friendly', 10, 20, 4, 'Easy', 'Baked Cinnamon Apple Slices.jpg', '[{\"ingredient\":\"Apples (Granny Smith)\",\"quantity\":\"2 large\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Nutmeg\",\"quantity\":\"1/4 tsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 375°F (190°C).\",\"Slice apples thinly.\",\"Toss apple slices with cinnamon, nutmeg, stevia, and butter.\",\"Spread on a baking sheet.\",\"Bake for 20 minutes until tender.\"]', 'Yassine zeort', '2025-04-20 21:14:08', 4),
(99, 'Keto Blueberry Muffins', 'Fluffy almond flour muffins filled with juicy blueberries — perfect for a low-carb, diabetic-friendly treat.', 'Diabetic-Friendly', 15, 20, 8, 'Medium', 'Keto Blueberry Muffins.jpg', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 1/2 tsp\"},{\"ingredient\":\"Eggs\",\"quantity\":\"3\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Fresh blueberries\",\"quantity\":\"3/4 cup\"}]', '[\"Preheat oven to 350°F (175°C) and line muffin tin.\",\"Mix almond flour and baking powder.\",\"In another bowl, whisk eggs, butter, vanilla, and stevia.\",\"Combine wet and dry ingredients, then fold in blueberries.\",\"Spoon into muffin cups and bake for 18-20 minutes.\"]', 'Yassine zeort', '2025-04-20 21:14:21', 4),
(100, 'Chocolate Chia Seed Pudding', 'A creamy, chocolatey pudding that\'s sugar-free, fiber-packed, and perfect for diabetics.', 'Diabetic-Friendly', 10, 0, 4, 'Easy', 'Chocolate Chia Seed Pudding.jpg', '[{\"ingredient\":\"Chia seeds\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Unsweetened almond milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1-2 tbsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1/2 tsp\"}]', '[\"In a bowl, whisk together almond milk, cocoa, stevia, and vanilla.\",\"Add chia seeds and mix well.\",\"Cover and refrigerate overnight or at least 4 hours.\",\"Stir before serving. Top with nuts or berries if desired.\"]', 'Yassine zeort', '2025-04-20 21:14:32', 4),
(101, 'Sugar-Free Vanilla Panna Cotta', 'A silky smooth Italian dessert with no added sugar, made safe for diabetic diets.', 'Diabetic-Friendly', 15, 0, 6, 'Medium', 'Sugar-Free Vanilla Panna Cotta.jpg', '[{\"ingredient\":\"Heavy cream\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Unsweetened almond milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Gelatin powder\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Water\",\"quantity\":\"3 tbsp\"}]', '[\"Sprinkle gelatin over water and let it bloom for 5 minutes.\",\"Heat cream and almond milk in a saucepan over low heat.\",\"Add stevia and vanilla extract.\",\"Add the gelatin mixture and stir until dissolved.\",\"Pour into serving cups and refrigerate until set, about 4 hours.\"]', 'Yassine zeort', '2025-04-20 21:14:46', 4),
(102, 'Lemon Ricotta Cheesecake', 'Light and fluffy cheesecake flavored with fresh lemon zest and no refined sugars — perfect for diabetic-friendly desserts.', 'Diabetic-Friendly', 20, 50, 8, 'Hard', 'Lemon Ricotta Cheesecake.jpg', '[{\"ingredient\":\"Ricotta cheese\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Cream cheese\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"3\"},{\"ingredient\":\"Lemon zest\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Almond flour crust (optional)\",\"quantity\":\"1 pre-baked\"}]', '[\"Preheat oven to 325°F (160°C).\",\"Blend ricotta and cream cheese until smooth.\",\"Add stevia, eggs, lemon zest, and vanilla; blend again.\",\"Pour over the pre-baked almond flour crust (optional) or into a greased pan.\",\"Bake for 45-50 minutes. Cool completely before slicing.\"]', 'Yassine zeort', '2025-04-20 21:14:59', 4),
(103, 'Almond Butter Cookies (No Sugar)', 'Soft, chewy cookies made with almond butter and sweetened with stevia — safe for diabetic snackers.', 'Diabetic-Friendly', 10, 12, 12, 'Easy', 'Almond Butter Cookies (No Sugar).jpg', '[{\"ingredient\":\"Almond butter\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1/2 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix all ingredients in a bowl.\",\"Scoop dough onto a baking sheet lined with parchment.\",\"Flatten slightly with a fork.\",\"Bake for 10-12 minutes. Cool on wire racks.\"]', 'Yassine zeort', '2025-04-20 21:15:11', 4),
(104, 'Coconut Flour Chocolate Chip Cake', 'A moist, fluffy cake using coconut flour and sugar-free chocolate chips — diabetic-approved.', 'Diabetic-Friendly', 15, 30, 8, 'Medium', 'Coconut Flour Chocolate Chip Cake.jpg', '[{\"ingredient\":\"Coconut flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"4\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Sugar-free chocolate chips\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Whisk together eggs, butter, stevia, and vanilla.\",\"Add coconut flour and baking powder.\",\"Fold in chocolate chips.\",\"Pour batter into a greased cake pan and bake for 25-30 minutes.\"]', 'Yassine zeort', '2025-04-20 21:15:22', 4),
(105, 'Lactose-Free Vanilla Almond Cake', 'A light and fluffy vanilla cake with almond flavor, perfect for any occasion.', 'Dairy-Free', 20, 30, 8, 'Medium', 'Lactose-Free Vanilla Almond Cake.jpg', '• 1 1/2 cups almond flour\n• 1/4 cup coconut flour\n• 1 tsp baking soda\n• 1/4 cup almond milk\n• 2 eggs\n• 1/4 cup maple syrup\n• 1 tsp vanilla extract', '1. Preheat oven to 350°F (175°C).\n2. Mix almond flour, coconut flour, and baking soda in a bowl.\n3. In a separate bowl, whisk eggs, almond milk, maple syrup, and vanilla extract.\n4. Combine both mixtures and pour into a greased cake pan.\n5. Bake for 30 minutes.\n6. Let cool, then frost if desired.', 'MiraKamal', '2025-04-20 21:18:43', 2),
(106, 'Lactose-Free Tiramisu', 'A decadent lactose-free version of the classic Italian tiramisu made with dairy-free mascarpone and almond milk.', 'Dairy-Free', 30, 0, 8, 'Medium', 'Lactose-Free Tiramisu.jpg', '• 1 cup lactose-free mascarpone cheese\n• 1 cup almond milk\n• 2 tbsp sugar\n• 1 tsp vanilla extract\n• 1 cup brewed coffee (cooled)\n• 1 pack of lactose-free ladyfingers\n• 2 tbsp cocoa powder\n• 1 tbsp cocoa nibs (optional)', '1. Whisk the lactose-free mascarpone, almond milk, sugar, and vanilla extract until smooth.\n2. Dip the ladyfingers into the brewed coffee, then layer them at the bottom of a dish.\n3. Spread half the mascarpone mixture over the ladyfingers.\n4. Repeat the layers, then chill for at least 2 hours.\n5. Sprinkle cocoa powder and nibs on top before serving.', 'MiraKamal', '2025-04-20 21:19:03', 2),
(107, 'Lactose-Free Churros with Chocolate Sauce', 'Delicious, golden brown churros with a rich lactose-free chocolate dipping sauce.', 'Dairy-Free', 20, 25, 8, 'Medium', 'Lactose-Free Churros with Chocolate Sauce.jpg', '• 1 cup gluten-free flour\n• 1 tbsp sugar\n• 1/2 tsp baking powder\n• 1/4 tsp salt\n• 1/2 cup water\n• 2 tbsp dairy-free butter\n• 1/4 tsp cinnamon\n• 1/2 cup lactose-free dark chocolate\n• 1/4 cup almond milk', '1. In a saucepan, combine water, dairy-free butter, sugar, and salt. Bring to a boil, then stir in flour until a dough forms.\n2. Let the dough cool slightly, then pipe into hot oil to form churros and fry until golden brown.\n3. For the sauce, melt lactose-free chocolate with almond milk until smooth.\n4. Dip churros into the chocolate sauce and serve hot.', 'MiraKamal', '2025-04-20 21:19:36', 2),
(108, 'Lactose-Free Salted Caramel Cheesecake', 'A smooth, creamy lactose-free cheesecake with a rich salted caramel topping.', 'Dairy-Free', 25, 60, 10, 'Hard', 'Lactose-Free Salted Caramel Cheesecake.jpg', '• 2 cups gluten-free graham cracker crumbs\n• 1/4 cup dairy-free butter, melted\n• 2 cups lactose-free cream cheese\n• 1/4 cup maple syrup\n• 1/4 cup coconut cream\n• 2 tsp vanilla extract\n• 1/2 cup salted caramel sauce', '1. Preheat the oven to 325°F (165°C).\n2. Combine graham cracker crumbs and melted butter. Press into the base of a cheesecake pan.\n3. Beat together cream cheese, maple syrup, coconut cream, and vanilla until smooth.\n4. Pour the mixture over the crust and bake for 60 minutes.\n5. Let the cheesecake cool, then refrigerate for at least 4 hours.\n6. Top with salted caramel sauce before serving.', 'MiraKamal', '2025-04-20 21:19:53', 2),
(109, 'Lactose-Free Chocolate Lava Cake', 'Decadent molten chocolate cake with a gooey center, made with dairy-free ingredients.', 'Dairy-Free', 15, 20, 4, 'Medium', 'Lactose-Free Chocolate Lava Cake.jpg', '• 1/2 cup dairy-free dark chocolate\n• 1/4 cup dairy-free butter\n• 1/2 cup gluten-free flour\n• 1/4 cup maple syrup\n• 2 eggs\n• 1 tsp vanilla extract\n• 1/4 tsp salt', '1. Preheat the oven to 425°F (220°C) and grease 4 ramekins.\n2. Melt dairy-free dark chocolate and butter in a saucepan.\n3. In a bowl, mix flour, maple syrup, eggs, vanilla, and salt.\n4. Combine the chocolate mixture with the flour mixture.\n5. Pour into ramekins and bake for 12-14 minutes until the edges are set but the center is soft.\n6. Let cool for 5 minutes, then carefully invert to serve.', 'MiraKamal', '2025-04-20 21:20:08', 2),
(110, 'Lactose-Free Mango Sorbet', 'A refreshing mango sorbet with a smooth, creamy texture and tropical sweetness.', 'Dairy-Free', 10, 0, 6, 'Easy', 'Lactose-Free Mango Sorbet.jpg', '• 3 ripe mangoes, peeled and chopped\n• 1/4 cup lime juice\n• 1/2 cup maple syrup\n• 1/4 cup coconut water', '1. Puree the mangoes in a blender with lime juice, maple syrup, and coconut water.\n2. Pour into a shallow dish and freeze for 4 hours.\n3. Scrape the mixture with a fork every 30 minutes until it reaches a slushy consistency.\n4. Serve chilled.', 'MiraKamal', '2025-04-20 21:20:20', 2),
(111, 'Lactose-Free Strawberry Shortcake', 'A classic strawberry shortcake made with lactose-free ingredients, perfect for summer desserts.', 'Dairy-Free', 20, 30, 6, 'Medium', 'Lactose-Free Strawberry Shortcake.jpg', '• 1 1/2 cups gluten-free flour\n• 1/4 cup coconut sugar\n• 1 tsp baking powder\n• 1/4 cup dairy-free butter\n• 1/2 cup almond milk\n• 2 cups fresh strawberries, sliced\n• 2 tbsp maple syrup', '1. Preheat the oven to 350°F (175°C).\n2. In a bowl, mix gluten-free flour, coconut sugar, and baking powder.\n3. Cut in the dairy-free butter until the mixture resembles breadcrumbs. Add almond milk and stir to form a dough.\n4. Drop spoonfuls of dough onto a baking sheet and bake for 20-25 minutes.\n5. For the topping, mix strawberries and maple syrup, then serve with the warm shortcakes.', 'MiraKamal', '2025-04-20 21:20:33', 2),
(112, 'Lactose-Free Banana Bread with Walnuts', 'A moist, flavorful banana bread with crunchy walnuts, made without dairy.', 'Dairy-Free', 15, 45, 10, 'Medium', 'Lactose-Free Banana Bread with Walnuts.jpg', '• 2 ripe bananas, mashed\n• 2 cups gluten-free flour\n• 1/4 cup coconut sugar\n• 1/4 cup almond milk\n• 1/2 cup chopped walnuts\n• 1 tsp baking powder\n• 1/2 tsp baking soda\n• 1/4 tsp salt', '1. Preheat the oven to 350°F (175°C). Grease a loaf pan.\n2. Mix mashed bananas, coconut sugar, and almond milk in a bowl.\n3. In a separate bowl, combine gluten-free flour, baking powder, baking soda, and salt.\n4. Combine both mixtures, stir in walnuts, and pour into the pan.\n5. Bake for 45 minutes or until a toothpick comes out clean.', 'MiraKamal', '2025-04-20 21:20:47', 2),
(113, 'Lactose-Free Apple Crumble', 'Warm, spiced apples topped with a crisp, buttery crumble topping, made without dairy.', 'Dairy-Free', 15, 40, 6, 'Medium', 'Lactose-Free Apple Crumble.jpg', '• 4 apples, peeled and sliced\n• 1/2 cup gluten-free oats\n• 1/4 cup coconut flour\n• 1/4 cup coconut sugar\n• 1/4 cup dairy-free butter\n• 1/2 tsp cinnamon', '1. Preheat the oven to 350°F (175°C). Grease a baking dish.\n2. Arrange the sliced apples in the dish and sprinkle with cinnamon.\n3. In a bowl, combine oats, coconut flour, coconut sugar, and melted dairy-free butter to form the crumble topping.\n4. Spread the topping over the apples and bake for 30-40 minutes until golden.', 'MiraKamal', '2025-04-20 21:20:58', 2),
(114, 'Lactose-Free Chocolate Hazelnut Tart', 'A rich and indulgent tart with a smooth chocolate filling and crunchy hazelnut crust.', 'Dairy-Free', 25, 30, 8, 'Hard', 'Lactose-Free Chocolate Hazelnut Tart.jpg', '• 1 1/2 cups ground hazelnuts\n• 1/2 cup gluten-free flour\n• 1/4 cup maple syrup\n• 1/4 cup dairy-free butter\n• 1 cup lactose-free dark chocolate\n• 1/4 cup coconut cream\n• 1/2 tsp vanilla extract\n• 1/4 cup roasted hazelnuts for garnish', '1. Preheat the oven to 350°F (175°C).\n2. Combine ground hazelnuts, gluten-free flour, maple syrup, and dairy-free butter. Press into the tart pan.\n3. Bake for 15-20 minutes until golden.\n4. In a saucepan, melt lactose-free dark chocolate with coconut cream and vanilla extract.\n5. Pour the chocolate mixture into the cooled crust and refrigerate until set.\n6. Garnish with roasted hazelnuts before serving.', 'MiraKamal', '2025-04-20 21:23:15', 2);

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
-- Table structure for table `recipe_rating`
--

CREATE TABLE `recipe_rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL
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
(3, 'rim', 'rim.serhan@lau.edu', '$2y$10$1ZDuNU6QPaq16P0jCyJFquCVc5vpPE39VAbD4fIPih/u9Fc9WhFQG', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(4, 'Yassine zeort', 'yassine.elzeort@lau.edu', '$2y$10$1KsoPGYI6CRj/Czp4xb3IOvGT.lngKoVf4BHk3mt9Jibx1YF9shjO', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker');

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
-- Indexes for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
  ADD CONSTRAINT `recipe_rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_rating_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

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
