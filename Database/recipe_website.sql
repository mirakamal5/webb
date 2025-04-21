-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 01:12 PM
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
(114, 'Lactose-Free Chocolate Hazelnut Tart', 'A rich and indulgent tart with a smooth chocolate filling and crunchy hazelnut crust.', 'Dairy-Free', 25, 30, 8, 'Hard', 'Lactose-Free Chocolate Hazelnut Tart.jpg', '• 1 1/2 cups ground hazelnuts\n• 1/2 cup gluten-free flour\n• 1/4 cup maple syrup\n• 1/4 cup dairy-free butter\n• 1 cup lactose-free dark chocolate\n• 1/4 cup coconut cream\n• 1/2 tsp vanilla extract\n• 1/4 cup roasted hazelnuts for garnish', '1. Preheat the oven to 350°F (175°C).\n2. Combine ground hazelnuts, gluten-free flour, maple syrup, and dairy-free butter. Press into the tart pan.\n3. Bake for 15-20 minutes until golden.\n4. In a saucepan, melt lactose-free dark chocolate with coconut cream and vanilla extract.\n5. Pour the chocolate mixture into the cooled crust and refrigerate until set.\n6. Garnish with roasted hazelnuts before serving.', 'MiraKamal', '2025-04-20 21:23:15', 2),
(115, 'Coconut Macaroons', 'Chewy, sweet, and naturally gluten-free coconut macaroons made with just a few wholesome ingredients.', 'Gluten-Free', 15, 20, 15, 'Easy', 'images/default.png', '[{\"ingredient\":\"Shredded coconut\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Sweetened condensed milk\",\"quantity\":\"2/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Egg whites\",\"quantity\":\"2\"}]', '[\"Preheat oven to 325°F (165°C).\",\"Mix coconut, condensed milk, and vanilla.\",\"Whisk egg whites until stiff peaks form.\",\"Gently fold egg whites into coconut mixture.\",\"Scoop small mounds onto a baking sheet.\",\"Bake for 18-20 minutes until golden.\"]', 'Mohammad Zeitoun', '2025-04-21 09:32:25', 5),
(116, 'Lemon Almond Cake', 'Moist and fragrant almond cake flavored with lemon zest — no flour needed, perfect for gluten-free diets.', 'Gluten-Free', 20, 35, 8, 'Medium', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Eggs\",\"quantity\":\"4\"},{\"ingredient\":\"Honey\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Lemon zest\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Whisk eggs, honey, and lemon zest.\",\"Add almond flour and baking powder.\",\"Pour into a greased cake pan.\",\"Bake for 30-35 minutes until golden.\"]', 'Mohammad Zeitoun', '2025-04-21 09:32:38', 5),
(117, 'Flourless Chocolate Cake', 'A rich, decadent chocolate cake without any flour — pure indulgence for gluten-free dessert lovers.', 'Gluten-Free', 20, 30, 10, 'Hard', 'images/default.png', '[{\"ingredient\":\"Dark chocolate (70%)\",\"quantity\":\"200g\"},{\"ingredient\":\"Butter\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Sugar\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"4\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 375°F (190°C).\",\"Melt chocolate and butter together.\",\"Beat eggs and sugar until thick.\",\"Fold chocolate mixture into eggs.\",\"Add cocoa powder.\",\"Bake in greased pan for 25-30 minutes.\"]', 'Mohammad Zeitoun', '2025-04-21 09:32:52', 5),
(118, 'Peanut Butter Blondies', 'Fudgy peanut butter blondies made with almond flour — a dreamy gluten-free dessert.', 'Gluten-Free', 10, 20, 12, 'Easy', 'images/default.png', '[{\"ingredient\":\"Peanut butter\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Stevia or sugar\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1/2 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix all ingredients until smooth.\",\"Pour into a lined baking pan.\",\"Bake for 18-20 minutes.\",\"Cool completely before slicing.\"]', 'Mohammad Zeitoun', '2025-04-21 09:33:03', 5),
(119, 'Strawberry Shortcake', 'Fluffy almond flour biscuits layered with whipped cream and fresh strawberries — gluten-free twist on a classic.', 'Gluten-Free', 25, 20, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Butter, cold\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Heavy cream\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Strawberries\",\"quantity\":\"1 pint\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix almond flour and baking powder.\",\"Cut in butter.\",\"Add eggs and cream to form dough.\",\"Scoop onto baking sheet and bake 15-20 minutes.\",\"Top with whipped cream and strawberries.\"]', 'Mohammad Zeitoun', '2025-04-21 09:33:20', 5),
(120, 'Cinnamon Apple Crisp', 'A warm gluten-free apple dessert topped with a crunchy almond oat crumble.', 'Gluten-Free', 15, 30, 6, 'Easy', 'images/default.png', '[{\"ingredient\":\"Apples\",\"quantity\":\"4, sliced\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Rolled oats (GF-certified)\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Brown sugar\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Toss apples with cinnamon.\",\"Mix oats, almond flour, butter, and brown sugar.\",\"Place apples in dish, top with crumble.\",\"Bake for 30 minutes until golden.\"]', 'Mohammad Zeitoun', '2025-04-21 09:33:32', 5),
(121, 'Gluten-Free Carrot Cake', 'A moist, spiced carrot cake made without gluten, perfect for celebrations.', 'Gluten-Free', 30, 45, 10, 'Hard', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Grated carrots\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Eggs\",\"quantity\":\"4\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Nutmeg\",\"quantity\":\"1/4 tsp\"},{\"ingredient\":\"Sugar substitute\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix dry ingredients.\",\"Add eggs and carrots.\",\"Pour into greased pans.\",\"Bake 40-45 minutes.\",\"Frost with cream cheese frosting if desired.\"]', 'Mohammad Zeitoun', '2025-04-21 09:33:42', 5),
(122, 'Cherry Almond Bars', 'Sweet cherry almond bars with a tender gluten-free shortbread crust.', 'Gluten-Free', 20, 35, 9, 'Medium', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Butter\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Cherries, pitted\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Honey or stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix almond flour and butter to form dough.\",\"Press into baking pan.\",\"Spread cherries on top.\",\"Drizzle honey.\",\"Bake for 30-35 minutes.\"]', 'Mohammad Zeitoun', '2025-04-21 09:34:03', 5),
(123, 'Gluten-Free Vanilla Custard', 'Smooth, creamy vanilla custard made without gluten-containing thickeners.', 'Gluten-Free', 10, 15, 4, 'Medium', 'images/default.png', '[{\"ingredient\":\"Milk (or almond milk)\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Egg yolks\",\"quantity\":\"4\"},{\"ingredient\":\"Stevia or sugar substitute\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Cornstarch\",\"quantity\":\"2 tbsp\"}]', '[\"Heat milk until simmering.\",\"Whisk yolks, sweetener, vanilla, and cornstarch.\",\"Temper hot milk into yolk mixture.\",\"Cook until thickened, stirring constantly.\",\"Chill before serving.\"]', 'Mohammad Zeitoun', '2025-04-21 09:34:15', 5),
(124, 'Gluten-Free Banana Bread', 'Moist and naturally sweet banana bread made without any gluten-containing ingredients.', 'Gluten-Free', 15, 50, 8, 'Easy', 'images/default.png', '[{\"ingredient\":\"Mashed bananas\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Eggs\",\"quantity\":\"3\"},{\"ingredient\":\"Honey or stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix wet ingredients.\",\"Add dry ingredients.\",\"Pour into greased loaf pan.\",\"Bake 50 minutes until a toothpick comes out clean.\"]', 'Mohammad Zeitoun', '2025-04-21 09:34:27', 5),
(125, 'Vegan Chocolate Cake', 'Rich and moist chocolate cake made without eggs or dairy, using apple cider vinegar for extra fluffiness.', 'Egg-Free', 30, 40, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Apple cider vinegar\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Coconut oil, melted\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Stevia or sugar substitute\",\"quantity\":\"1 cup\"}]', '[\"Preheat oven to 350°F (175°C). Grease two 8-inch round cake pans.\",\"Whisk flour, cocoa powder, baking soda, and salt.\",\"In another bowl, combine almond milk, apple cider vinegar, oil, vanilla, and sweetener.\",\"Mix wet into dry ingredients until smooth.\",\"Divide batter into pans and bake for 35-40 minutes.\",\"Cool completely before frosting.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(126, 'Egg-Free Lemon Bars', 'Tangy and sweet lemon bars with a shortbread crust made without eggs, perfect for citrus lovers.', 'Egg-Free', 20, 30, 9, 'Medium', 'images/default.png', '[{\"ingredient\":\"Flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Butter, softened\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Cornstarch\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Lemon juice\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Lemon zest\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Sweetened condensed coconut milk\",\"quantity\":\"1/2 cup\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix flour, butter, and stevia to form dough.\",\"Press into pan and bake 10 minutes.\",\"Whisk lemon juice, zest, and coconut milk.\",\"Pour over baked crust and bake another 20 minutes.\",\"Cool and slice.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(127, 'Banana Bread (Egg-Free)', 'Deliciously moist banana bread without any eggs, using overripe bananas and flaxseed.', 'Egg-Free', 20, 55, 10, 'Medium', 'images/default.png', '[{\"ingredient\":\"Flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Ripe bananas\",\"quantity\":\"3 large, mashed\"},{\"ingredient\":\"Flaxseed meal\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Water\",\"quantity\":\"6 tbsp\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Stevia or sweetener\",\"quantity\":\"1/2 cup\"}]', '[\"Preheat oven to 350°F (175°C). Grease a loaf pan.\",\"Mix flaxseed meal and water, let sit 5 minutes.\",\"Whisk dry ingredients.\",\"Mix bananas, flax egg, oil, vanilla, and sweetener.\",\"Combine wet and dry, pour into loaf pan.\",\"Bake 50-55 minutes.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(128, 'Eggless Brownie Bites', 'Fudgy chocolate brownie bites without eggs, perfect for a quick, rich treat.', 'Egg-Free', 15, 20, 12, 'Easy', 'images/default.png', '[{\"ingredient\":\"Flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Unsweetened applesauce\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Coconut oil, melted\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix flour, cocoa, baking powder, and salt.\",\"In another bowl, combine applesauce, oil, stevia, and vanilla.\",\"Mix wet and dry ingredients.\",\"Scoop into mini muffin tin and bake 18-20 minutes.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(129, 'Vegan Tiramisu Cups', 'Mini tiramisu desserts layered with coffee-soaked sponge and cashew cream, no eggs needed.', 'Egg-Free', 30, 0, 6, 'Hard', 'images/default.png', '[{\"ingredient\":\"Gluten-free ladyfingers\",\"quantity\":\"12 pieces\"},{\"ingredient\":\"Cashews, soaked\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut cream\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Coffee, brewed\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"2 tbsp\"}]', '[\"Blend cashews, coconut cream, and stevia until smooth.\",\"Dip ladyfingers quickly in coffee.\",\"Layer ladyfingers and cream in small glasses.\",\"Dust with cocoa powder.\",\"Refrigerate 3 hours before serving.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(130, 'Apple Cinnamon Muffins (Egg-Free)', 'Soft, warm muffins filled with diced apples and fragrant cinnamon, made without eggs.', 'Egg-Free', 15, 25, 10, 'Medium', 'images/default.png', '[{\"ingredient\":\"Flour\",\"quantity\":\"1 3/4 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Apples, diced\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut oil, melted\",\"quantity\":\"1/4 cup\"}]', '[\"Preheat oven to 375°F (190°C).\",\"Mix dry ingredients together.\",\"In another bowl, mix milk and oil.\",\"Fold wet into dry, add apples.\",\"Fill muffin tins and bake 20-25 minutes.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(131, 'No-Egg Pumpkin Pie', 'A creamy and spiced pumpkin pie that sets perfectly without any eggs, ideal for festive tables.', 'Egg-Free', 20, 50, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"Pumpkin puree\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut milk\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Cornstarch\",\"quantity\":\"3 tbsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Pumpkin pie spice\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Gluten-free pie crust\",\"quantity\":\"1\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Whisk pumpkin, coconut milk, cornstarch, stevia, spice, and vanilla.\",\"Pour into pie crust.\",\"Bake 50 minutes.\",\"Cool and refrigerate overnight.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(132, 'Vegan Chocolate Chip Cookies', 'Classic chewy chocolate chip cookies made without eggs, sweet and satisfying.', 'Egg-Free', 15, 12, 14, 'Easy', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"1 3/4 cups\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/4 tsp\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Sugar-free chocolate chips\",\"quantity\":\"3/4 cup\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix flour, baking soda, and salt.\",\"Cream coconut oil and stevia.\",\"Add milk and vanilla.\",\"Mix dry into wet ingredients, then stir in chocolate chips.\",\"Scoop onto baking sheet and bake 10-12 minutes.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(133, 'Coconut Rice Pudding (Egg-Free)', 'Creamy coconut rice pudding made with almond milk and fragrant cinnamon, no eggs.', 'Egg-Free', 10, 30, 4, 'Easy', 'images/default.png', '[{\"ingredient\":\"White rice, cooked\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"In a saucepan, combine cooked rice, coconut milk, almond milk, stevia, cinnamon, and vanilla.\",\"Simmer for 25-30 minutes, stirring occasionally.\",\"Serve warm or chilled.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(134, 'Vegan Carrot Cake with Cashew Frosting', 'Moist, spiced carrot cake with a creamy cashew frosting, egg-free and rich.', 'Egg-Free', 30, 40, 10, 'Hard', 'images/default.png', '[{\"ingredient\":\"Flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Nutmeg\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Salt\",\"quantity\":\"1/2 tsp\"},{\"ingredient\":\"Carrots, grated\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Cashews, soaked\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Maple syrup (sugar-free)\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix flour, baking soda, cinnamon, nutmeg, and salt.\",\"In another bowl, combine carrots, oil, stevia, and milk.\",\"Mix dry into wet ingredients.\",\"Pour into cake pans and bake 35-40 minutes.\",\"For frosting, blend cashews and maple syrup until smooth.\",\"Frost cooled cake.\"]', 'Ahmad Sabra', '2025-04-21 09:43:53', 6),
(135, 'Vegan Chocolate Avocado Mousse', 'A rich, creamy, and healthy vegan chocolate mousse using avocados.', 'Vegan', 10, 0, 4, 'Easy', 'images/default.png', '[{\"ingredient\":\"Ripe avocados\",\"quantity\":\"2\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"3 tbsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"Blend avocados until smooth.\",\"Add cocoa powder, maple syrup, and vanilla extract.\",\"Blend until creamy.\",\"Chill before serving.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(136, 'Vegan Lemon Poppy Seed Muffins', 'Light and fluffy lemony muffins without any eggs or dairy.', 'Vegan', 20, 25, 10, 'Medium', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Coconut yogurt\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Lemon juice\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Poppy seeds\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350°F.\",\"Mix dry ingredients together.\",\"In another bowl mix yogurt, lemon juice, and maple syrup.\",\"Combine wet and dry ingredients.\",\"Fold in poppy seeds.\",\"Bake for 20-25 minutes.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(137, 'Vegan Strawberry Shortcake', 'Delicious vegan biscuits layered with coconut whipped cream and fresh strawberries.', 'Vegan', 30, 20, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Vegan butter\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Plant milk\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Strawberries\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut cream\",\"quantity\":\"1 can\"}]', '[\"Preheat oven to 400°F.\",\"Mix flour and baking powder.\",\"Cut in vegan butter.\",\"Add milk and form dough.\",\"Cut biscuits and bake.\",\"Whip coconut cream.\",\"Layer biscuits with strawberries and cream.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(138, 'Vegan Carrot Cake with Cashew Frosting', 'Moist and spicy carrot cake topped with creamy cashew frosting.', 'Vegan', 25, 40, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"Grated carrots\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Chopped walnuts\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Cashews, soaked\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Lemon juice\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 350°F.\",\"Mix dry and wet ingredients separately.\",\"Combine and fold in carrots and walnuts.\",\"Bake in a loaf pan.\",\"Blend cashews with lemon juice and maple syrup for frosting.\",\"Frost cooled cake.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(139, 'Vegan Chocolate Lava Cakes', 'Rich individual lava cakes with gooey chocolate centers.', 'Vegan', 15, 12, 4, 'Hard', 'images/default.png', '[{\"ingredient\":\"Dark chocolate, chopped\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Flaxseed meal\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/4 cup\"}]', '[\"Preheat oven to 375°F.\",\"Mix flaxseed meal with water to create flax eggs.\",\"Melt chocolate and coconut oil.\",\"Mix all ingredients.\",\"Pour into ramekins.\",\"Bake for 12 minutes.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(140, 'Vegan Coconut Macaroons', 'Soft and chewy coconut cookies made without egg whites.', 'Vegan', 10, 20, 20, 'Easy', 'images/default.png', '[{\"ingredient\":\"Shredded coconut\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut milk\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 325°F.\",\"Mix all ingredients.\",\"Scoop into mounds onto a baking sheet.\",\"Bake until golden brown.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(141, 'Vegan Matcha Cheesecake Bars', 'Lush green tea flavored cheesecake bars, completely vegan and raw.', 'Vegan', 30, 0, 9, 'Hard', 'images/default.png', '[{\"ingredient\":\"Cashews, soaked\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut cream\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Matcha powder\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Almonds\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Dates\",\"quantity\":\"1 cup\"}]', '[\"Blend almonds and dates for crust.\",\"Press into a pan.\",\"Blend cashews, coconut cream, maple syrup, and matcha.\",\"Pour over crust.\",\"Freeze until firm.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(142, 'Vegan Pumpkin Pie', 'Classic pumpkin pie made dairy-free and egg-free.', 'Vegan', 20, 50, 8, 'Medium', 'images/default.png', '[{\"ingredient\":\"Pumpkin puree\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Pumpkin pie spice\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Cornstarch\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 350°F.\",\"Blend all ingredients.\",\"Pour into pie crust.\",\"Bake for 45-50 minutes.\",\"Cool completely.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(143, 'Vegan Raspberry Almond Tart', 'Fresh raspberries and almond cream in a gluten-free vegan crust.', 'Vegan', 25, 25, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Fresh raspberries\",\"quantity\":\"1 cup\"}]', '[\"Preheat oven to 350°F.\",\"Mix almond flour, syrup, and coconut oil.\",\"Press into tart pan.\",\"Bake crust.\",\"Top with raspberries and chill.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(144, 'Vegan Chocolate Peanut Butter Pie', 'A decadent no-bake vegan dessert with layers of peanut butter and chocolate.', 'Vegan', 30, 0, 10, 'Hard', 'images/default.png', '[{\"ingredient\":\"Peanut butter\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut cream\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Dark chocolate\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Almonds\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Dates\",\"quantity\":\"1 cup\"}]', '[\"Blend almonds and dates for crust.\",\"Press into pie pan.\",\"Mix peanut butter, coconut cream, and syrup.\",\"Pour into crust.\",\"Melt chocolate and spread on top.\",\"Freeze until firm.\"]', 'Rawad Allam', '2025-04-21 09:47:54', 7),
(145, 'Nut-Free Chocolate Chip Blondies', 'Moist and chewy blondies loaded with dairy-free chocolate chips, completely nut-free for safe indulgence.', 'Nut-Free', 15, 25, 9, 'Medium', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Brown sugar substitute\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Nut-free chocolate chips\",\"quantity\":\"1/2 cup\"}]', '[\"Preheat oven to 350°F (175°C).\",\"Mix melted butter and sugar substitute.\",\"Add egg and vanilla; stir well.\",\"Fold in flour and baking powder, then chocolate chips.\",\"Pour into greased pan and bake 20-25 minutes.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(146, 'Raspberry Coconut Panna Cotta', 'A rich, silky coconut milk panna cotta topped with a fresh raspberry layer — naturally nut-free and elegant.', 'Nut-Free', 25, 5, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"Full-fat coconut milk\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Agar-agar powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Fresh raspberries\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Lemon juice\",\"quantity\":\"1 tbsp\"}]', '[\"Heat coconut milk, stevia, and vanilla. Sprinkle agar-agar and stir.\",\"Pour into glasses and chill.\",\"Puree raspberries with lemon juice.\",\"Top coconut layer with raspberry puree.\",\"Chill 4 hours before serving.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(147, 'Pumpkin Spice Rice Pudding', 'Creamy, spiced rice pudding flavored with real pumpkin puree — cozy and nut-free.', 'Nut-Free', 10, 40, 6, 'Easy', 'images/default.png', '[{\"ingredient\":\"Short-grain rice\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Milk\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Pumpkin puree\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Nutmeg\",\"quantity\":\"1/4 tsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"Rinse rice and simmer with milk.\",\"Cook until tender.\",\"Stir in pumpkin, spices, and vanilla.\",\"Cook 10-15 min more until creamy.\",\"Serve warm or chilled.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(148, 'Apple Cinnamon Oat Bars', 'Wholesome oat bars bursting with fresh apple and cinnamon flavor, perfect for nut-free snacking.', 'Nut-Free', 15, 30, 9, 'Medium', 'images/default.png', '[{\"ingredient\":\"Rolled oats\",\"quantity\":\"2 cups\"},{\"ingredient\":\"All-purpose flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Grated apple\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350°F.\",\"Mix oats, flour, cinnamon, baking powder.\",\"Add grated apple, butter, and syrup.\",\"Press into pan and bake for 25-30 min.\",\"Cool and slice into bars.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(149, 'Vanilla Rice Flour Cake', 'Soft and moist vanilla cake made entirely with rice flour, completely free from nuts and gluten.', 'Nut-Free', 20, 30, 8, 'Medium', 'images/default.png', '[{\"ingredient\":\"Rice flour\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"2 tsp\"},{\"ingredient\":\"Milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vegetable oil\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"}]', '[\"Preheat oven to 350°F.\",\"Mix rice flour and baking powder.\",\"Whisk wet ingredients separately.\",\"Combine wet and dry mixes.\",\"Pour into pan and bake 30 min.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(150, 'Chocolate Zucchini Muffins', 'Moist and secretly healthy chocolate muffins using shredded zucchini for extra tenderness.', 'Nut-Free', 20, 25, 12, 'Medium', 'images/default.png', '[{\"ingredient\":\"All-purpose flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Shredded zucchini\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 1/2 tsp\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"},{\"ingredient\":\"Milk\",\"quantity\":\"1/2 cup\"}]', '[\"Preheat oven to 350°F.\",\"Mix dry ingredients.\",\"Add wet ingredients and zucchini.\",\"Scoop into muffin tin.\",\"Bake 20-25 min.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(151, 'Peach Oat Crisp', 'Warm baked peaches topped with a hearty oat crisp — nut-free comfort food at its best.', 'Nut-Free', 15, 30, 6, 'Easy', 'images/default.png', '[{\"ingredient\":\"Fresh peaches, sliced\",\"quantity\":\"3 cups\"},{\"ingredient\":\"Rolled oats\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Butter\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 375°F.\",\"Place peaches in dish.\",\"Mix oats, flour, stevia, cinnamon, and butter.\",\"Top peaches with mixture.\",\"Bake 30 minutes until golden.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(152, 'Sugar-Free Banana Bread', 'Moist and naturally sweetened banana bread with no nuts and no added sugar.', 'Nut-Free', 15, 50, 10, 'Easy', 'images/default.png', '[{\"ingredient\":\"Bananas, mashed\",\"quantity\":\"3\"},{\"ingredient\":\"All-purpose flour\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Baking soda\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Egg\",\"quantity\":\"1\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Milk\",\"quantity\":\"1/2 cup\"}]', '[\"Preheat oven to 350°F.\",\"Mix dry ingredients.\",\"Mix mashed banana, egg, milk, and vanilla.\",\"Combine wet and dry.\",\"Bake 50 min.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(153, 'Berry Yogurt Bark', 'Frozen yogurt bark with fresh berries — an easy, refreshing, nut-free dessert.', 'Nut-Free', 10, 0, 8, 'Easy', 'images/default.png', '[{\"ingredient\":\"Greek yogurt\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Stevia\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Strawberries\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Blueberries\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"}]', '[\"Mix yogurt, stevia, and vanilla.\",\"Spread onto parchment paper.\",\"Top with berries.\",\"Freeze for 3 hours.\",\"Break into pieces.\"]', 'Jad Arab', '2025-04-21 10:00:28', 8),
(154, 'Nut-Free Honey Oatmeal Cake', 'A moist, hearty cake made with oats, coconut, and honey — completely nut-free and full of flavor.', 'Nut-Free', 20, 35, 10, 'Medium', 'images/default.png', '[{\"ingredient\": \"Old-fashioned oats\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Boiling water\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"All-purpose flour\", \"quantity\": \"1 1/3 cups\"}, {\"ingredient\": \"Baking soda\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Salt\", \"quantity\": \"1/2 tsp\"}, {\"ingredient\": \"Ground cinnamon\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Butter, softened\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Honey\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Brown sugar\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Eggs\", \"quantity\": \"2\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Shredded coconut (unsweetened)\", \"quantity\": \"1/2 cup\"}]', '[\"Preheat oven to 350°F (175°C). Grease a 9x9-inch baking dish.\", \"Pour boiling water over oats and let sit for 10 minutes.\", \"In a bowl, whisk together flour, baking soda, salt, and cinnamon.\", \"In a separate bowl, cream butter, honey, and brown sugar until fluffy.\", \"Beat in eggs and vanilla.\", \"Fold in soaked oats, then gradually add the flour mixture.\", \"Stir in shredded coconut.\", \"Pour batter into prepared pan.\", \"Bake for 30–35 minutes or until a toothpick inserted comes out clean.\", \"Cool before slicing and serving.\"]', 'Jad Arab', '2025-04-21 10:01:38', 8);
INSERT INTO `recipe` (`id`, `name`, `description`, `category`, `prep_time`, `cook_time`, `servings`, `difficulty`, `image`, `ingredients`, `steps`, `user`, `created_at`, `user_id`) VALUES
(155, 'Sugar-Free Chocolate Chip Cookies', 'Delicious chewy cookies made with almond flour and stevia-sweetened chocolate chips.', 'Sugar-Free', 15, 12, 12, 'Medium', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Egg\", \"quantity\": \"1\"}, {\"ingredient\": \"Baking powder\", \"quantity\": \"1/2 tsp\"}, {\"ingredient\": \"Sugar-free chocolate chips\", \"quantity\": \"3/4 cup\"}]', '[\"Preheat oven to 350°F (175°C).\", \"Mix almond flour, stevia, and baking powder.\", \"Add butter and egg; mix to form dough.\", \"Fold in sugar-free chocolate chips.\", \"Scoop onto baking sheet.\", \"Bake for 10-12 minutes.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(156, 'Sugar-Free Berry Yogurt Parfaits', 'Layered Greek yogurt, fresh berries, and a hint of stevia, no sugar needed.', 'Sugar-Free', 10, 0, 4, 'Easy', 'images/default.png', '[{\"ingredient\": \"Plain Greek yogurt\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Mixed berries\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Chia seeds\", \"quantity\": \"2 tbsp\"}]', '[\"Mix Greek yogurt and stevia.\", \"Layer yogurt, berries, and chia seeds in glasses.\", \"Chill before serving.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(157, 'Sugar-Free Peanut Butter Cups', 'Homemade peanut butter cups using sugar-free chocolate and creamy peanut butter.', 'Sugar-Free', 20, 0, 12, 'Medium', 'images/default.png', '[{\"ingredient\": \"Sugar-free chocolate\", \"quantity\": \"200g\"}, {\"ingredient\": \"Peanut butter (no sugar added)\", \"quantity\": \"1/2 cup\"}]', '[\"Melt half the chocolate and spoon into cupcake liners.\", \"Freeze until firm.\", \"Add peanut butter layer.\", \"Melt remaining chocolate and pour over.\", \"Freeze again until set.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(158, 'Sugar-Free Coconut Macaroons', 'Chewy coconut macaroons sweetened with stevia and optionally dipped in dark chocolate.', 'Sugar-Free', 15, 20, 12, 'Easy', 'images/default.png', '[{\"ingredient\": \"Unsweetened shredded coconut\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Egg whites\", \"quantity\": \"3\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Sugar-free dark chocolate (optional)\", \"quantity\": \"100g\"}]', '[\"Preheat oven to 325°F (160°C).\", \"Beat egg whites until peaks form; add stevia.\", \"Fold in coconut and vanilla.\", \"Scoop onto sheet and bake 18-20 min.\", \"Dip in chocolate if desired.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(159, 'Sugar-Free Cheesecake with Almond Crust', 'Classic cheesecake with a low-carb crust and no added sugar.', 'Sugar-Free', 25, 45, 10, 'Hard', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Cream cheese\", \"quantity\": \"24 oz\"}, {\"ingredient\": \"Eggs\", \"quantity\": \"3\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Sour cream\", \"quantity\": \"1/2 cup\"}]', '[\"Preheat oven to 325°F (160°C).\", \"Prepare crust with almond flour and butter.\", \"Beat cream cheese and stevia, then add eggs.\", \"Add vanilla and sour cream.\", \"Pour over crust and bake 45 min.\", \"Chill before serving.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(160, 'Sugar-Free Baked Cinnamon Donuts', 'Soft baked donuts covered in cinnamon and stevia.', 'Sugar-Free', 15, 12, 6, 'Medium', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Coconut flour\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Baking powder\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Eggs\", \"quantity\": \"3\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Cinnamon\", \"quantity\": \"1 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\", \"Mix dry and wet ingredients separately, then combine.\", \"Fill donut molds and bake 12 min.\", \"Dust with cinnamon after baking.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(161, 'Sugar-Free Apple Crumble', 'Tender apple filling with a crunchy almond oat topping.', 'Sugar-Free', 20, 30, 6, 'Medium', 'images/default.png', '[{\"ingredient\": \"Granny Smith apples\", \"quantity\": \"4\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Cinnamon\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Almond flour\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Rolled oats\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Nutmeg\", \"quantity\": \"1/4 tsp\"}]', '[\"Preheat oven to 350°F (175°C).\", \"Mix apples with spices and stevia.\", \"Prepare topping and sprinkle over apples.\", \"Bake for 30 minutes.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(162, 'Sugar-Free Cherry Chocolate Bark', 'A simple decadent sugar-free treat with chocolate and cherries.', 'Sugar-Free', 10, 5, 10, 'Easy', 'images/default.png', '[{\"ingredient\": \"Sugar-free dark chocolate\", \"quantity\": \"200g\"}, {\"ingredient\": \"Dried cherries\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Almonds (optional)\", \"quantity\": \"1/4 cup\"}]', '[\"Melt chocolate.\", \"Spread onto parchment and sprinkle cherries and almonds.\", \"Chill until hardened and break into pieces.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(163, 'Sugar-Free Pumpkin Pie', 'Classic pumpkin pie sweetened with stevia.', 'Sugar-Free', 30, 45, 8, 'Hard', 'images/default.png', '[{\"ingredient\": \"Pumpkin puree\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Eggs\", \"quantity\": \"3\"}, {\"ingredient\": \"Heavy cream\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Cinnamon\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Nutmeg\", \"quantity\": \"1/4 tsp\"}, {\"ingredient\": \"Ginger\", \"quantity\": \"1/4 tsp\"}]', '[\"Mix pumpkin, eggs, stevia, cream, and spices.\", \"Pour into crust.\", \"Bake at 350°F (175°C) for 45 minutes.\", \"Cool before slicing.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(164, 'Sugar-Free Oatmeal Raisin Cookies', 'Classic oatmeal cookies made without sugar.', 'Sugar-Free', 15, 15, 12, 'Medium', 'images/default.png', '[{\"ingredient\": \"Rolled oats\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Almond flour\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Cinnamon\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Egg\", \"quantity\": \"1\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Raisins\", \"quantity\": \"1/2 cup\"}]', '[\"Mix dry ingredients.\", \"Add egg and butter.\", \"Fold in raisins.\", \"Scoop and bake at 350°F (175°C) for 15 min.\"]', 'Ranime Ibrahim', '2025-04-21 10:08:56', 9),
(165, 'Chocolate Peanut Butter Protein Cake', 'Rich and moist chocolate cake packed with peanut butter and whey protein.', 'High-Protein', 20, 30, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Whey protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Peanut butter\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"3\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350F.\", \"Mix dry ingredients: almond flour, cocoa, protein, baking powder.\", \"Mix wet ingredients: peanut butter, eggs, stevia.\", \"Combine wet and dry. Pour into greased pan.\", \"Bake 25-30 min.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(166, 'Vanilla Protein Donuts', 'Fluffy baked donuts made with vanilla protein powder and almond flour.', 'High-Protein', 15, 15, 9, 'Medium', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Vanilla whey protein\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Baking powder\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Greek yogurt\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350F.\", \"Mix dry and wet ingredients separately.\", \"Combine and pour into donut molds.\", \"Bake 12-15 min.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(167, 'Berry Protein Cheesecake', 'A luscious cheesecake with a high-protein filling and fresh berry topping.', 'High-Protein', 25, 45, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"Cream cheese\",\"quantity\":\"200g\"},{\"ingredient\":\"Greek yogurt\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Vanilla whey protein\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Berries\",\"quantity\":\"1 cup\"}]', '[\"Preheat oven to 325F.\", \"Blend cream cheese, yogurt, protein, stevia, eggs.\", \"Pour into crust and bake 45 minutes.\", \"Top with berries after cooling.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(168, 'Oatmeal Chocolate Protein Cups', 'Mini oatmeal cups loaded with chocolate protein goodness.', 'High-Protein', 20, 20, 12, 'Medium', 'images/default.png', '[{\"ingredient\":\"Oats\",\"quantity\":\"1 1/2 cups\"},{\"ingredient\":\"Chocolate protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Milk\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Honey\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Chocolate chips\",\"quantity\":\"1/4 cup\"}]', '[\"Preheat oven to 350F.\", \"Mix all ingredients.\", \"Spoon into muffin cups.\", \"Bake 20 min.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(169, 'Peanut Butter Chocolate Protein Tart', 'A decadent tart with a peanut butter protein filling and a rich dark chocolate topping.', 'High-Protein', 30, 10, 8, 'Hard', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"3 tbsp\"},{\"ingredient\":\"Peanut butter\",\"quantity\":\"3/4 cup\"},{\"ingredient\":\"Vanilla whey protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Greek yogurt\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Dark chocolate (sugar-free)\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"1 tbsp\"}]', '[\"Mix almond flour, cocoa powder, and butter. Press into tart pan. Bake 10 min at 350F.\", \"Blend peanut butter, protein powder, and yogurt.\", \"Spread filling over cooled crust.\", \"Melt chocolate with coconut oil, pour on top, refrigerate.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(170, 'Chocolate Coconut Protein Bars', 'High-protein bars combining coconut, cocoa, and whey for a perfect energy boost!', 'High-Protein', 20, 0, 10, 'Medium', 'images/default.png', '[{\"ingredient\":\"Desiccated coconut\",\"quantity\":\"1 1/4 cups\"},{\"ingredient\":\"Chocolate whey protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Coconut oil, melted\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Honey or stevia syrup\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Unsweetened cocoa powder\",\"quantity\":\"2 tbsp\"}]', '[\"Mix coconut, protein powder, cocoa.\", \"Add coconut oil and sweetener.\", \"Press into tray, refrigerate.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(171, 'Apple Cinnamon Protein Crumble', 'Warm apple crumble with a high-protein oat topping.', 'High-Protein', 15, 25, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"Apples, diced\",\"quantity\":\"3\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Oats\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Vanilla protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Honey\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Butter\",\"quantity\":\"2 tbsp\"}]', '[\"Preheat oven to 350F.\", \"Toss apples with cinnamon and honey.\", \"Top with oat-protein mixture.\", \"Bake 25 minutes.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(172, 'High-Protein Chocolate Mousse', 'Silky mousse using Greek yogurt and whey protein.', 'High-Protein', 10, 0, 4, 'Easy', 'images/default.png', '[{\"ingredient\":\"Greek yogurt\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Chocolate whey protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Stevia\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Almond milk\",\"quantity\":\"2 tbsp\"}]', '[\"Whisk yogurt, cocoa, protein, stevia, and milk.\", \"Chill 1 hour before serving.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(173, 'Triple Chocolate Protein Brownies', 'Ultra-fudgy brownies packed with chocolate chips, cocoa, and protein.', 'High-Protein', 20, 25, 9, 'Hard', 'images/default.png', '[{\"ingredient\":\"Chocolate whey protein powder\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Oat flour\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Cocoa powder\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Sugar-free chocolate chips\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/3 cup\"}]', '[\"Preheat oven to 350F.\", \"Mix dry ingredients.\", \"Mix wet ingredients.\", \"Combine, fold chocolate chips.\", \"Bake 25 min.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(174, 'Caramel Peanut Butter Protein Blondies', 'Blondies infused with peanut butter and a rich caramel protein swirl.', 'High-Protein', 20, 25, 9, 'Hard', 'images/default.png', '[{\"ingredient\":\"Peanut butter\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vanilla whey protein\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Honey\",\"quantity\":\"1/3 cup\"},{\"ingredient\":\"Eggs\",\"quantity\":\"2\"},{\"ingredient\":\"Butter, melted\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Sugar-free caramel sauce\",\"quantity\":\"1/4 cup\"}]', '[\"Preheat oven to 350F.\", \"Mix all ingredients except caramel.\", \"Spread into pan, swirl caramel on top.\", \"Bake 25 min.\"]', 'Ali Safeidine', '2025-04-21 10:18:20', 10),
(175, 'No-Bake Chocolate Peanut Butter Bars', 'Rich layers of chocolate and peanut butter made without an oven.', 'No-Bake', 20, 0, 12, 'Easy', 'images/default.png', '[{\"ingredient\": \"Peanut butter\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Coconut flour\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Dark chocolate\", \"quantity\": \"200g\"}]', '[\"Mix peanut butter, coconut flour, and stevia.\", \"Press into a pan.\", \"Melt chocolate and pour over.\", \"Chill until firm.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(176, 'No-Bake Raspberry Cheesecake', 'Creamy cheesecake layered with fresh raspberries without needing baking.', 'No-Bake', 30, 0, 8, 'Medium', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Cream cheese\", \"quantity\": \"300g\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Raspberries\", \"quantity\": \"1 cup\"}]', '[\"Mix almond flour and butter; press into dish.\", \"Blend cream cheese, stevia, and vanilla.\", \"Spread over crust.\", \"Top with raspberries.\", \"Chill before serving.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(177, 'No-Bake Lemon Coconut Bars', 'Zesty lemon and sweet coconut come together in a simple no-bake treat.', 'No-Bake', 20, 0, 10, 'Easy', 'images/default.png', '[{\"ingredient\": \"Shredded coconut\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Coconut oil\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Lemon zest\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Lemon juice\", \"quantity\": \"1/4 cup\"}]', '[\"Mix all ingredients.\", \"Press into pan.\", \"Chill until firm.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(178, 'No-Bake Peanut Butter Oat Cups', 'Creamy peanut butter and crunchy oats combined into easy freezer cups.', 'No-Bake', 15, 0, 12, 'Easy', 'images/default.png', '[{\"ingredient\": \"Oats\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Peanut butter\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Honey\", \"quantity\": \"1/3 cup\"}]', '[\"Mix oats, peanut butter, and honey.\", \"Spoon into muffin tins.\", \"Freeze until solid.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(179, 'No-Bake Chocolate Almond Fudge', 'Rich, sugar-free almond chocolate fudge requiring zero baking.', 'No-Bake', 10, 0, 16, 'Easy', 'images/default.png', '[{\"ingredient\": \"Dark chocolate\", \"quantity\": \"200g\"}, {\"ingredient\": \"Almond butter\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Chopped almonds\", \"quantity\": \"1/2 cup\"}]', '[\"Melt chocolate and almond butter.\", \"Mix in stevia and almonds.\", \"Pour into pan and chill.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(180, 'No-Bake Coconut Cream Pie', 'Creamy, dreamy coconut filling over a nutty no-bake crust.', 'No-Bake', 30, 0, 8, 'Hard', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Shredded coconut\", \"quantity\": \"2 cups\"}, {\"ingredient\": \"Heavy cream\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Coconut milk\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Gelatin powder\", \"quantity\": \"1 tbsp\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}]', '[\"Make almond crust and chill.\", \"Prepare coconut filling.\", \"Pour and refrigerate 6 hours.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(181, 'No-Bake Blueberry Almond Tart', 'Luscious almond tart filled with creamy yogurt and fresh blueberries.', 'No-Bake', 25, 0, 8, 'Medium', 'images/default.png', '[{\"ingredient\": \"Almond flour\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Butter\", \"quantity\": \"1/4 cup\"}, {\"ingredient\": \"Cream cheese\", \"quantity\": \"250g\"}, {\"ingredient\": \"Greek yogurt\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"3 tbsp\"}, {\"ingredient\": \"Fresh blueberries\", \"quantity\": \"1 cup\"}]', '[\"Make crust and chill.\", \"Mix filling.\", \"Top with blueberries and refrigerate.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(182, 'No-Bake Cherry Chocolate Mousse', 'Rich chocolate mousse layered with juicy cherries.', 'No-Bake', 20, 0, 6, 'Hard', 'images/default.png', '[{\"ingredient\": \"Heavy cream\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Sugar-free dark chocolate\", \"quantity\": \"150g\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Fresh cherries\", \"quantity\": \"1 cup\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}]', '[\"Melt chocolate.\", \"Whip cream.\", \"Combine and layer with cherries.\", \"Chill.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(183, 'No-Bake Mocha Energy Bites', 'Bold coffee-flavored cocoa oat energy bites.', 'No-Bake', 15, 0, 20, 'Easy', 'images/default.png', '[{\"ingredient\": \"Rolled oats\", \"quantity\": \"1 1/2 cups\"}, {\"ingredient\": \"Almond butter\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Honey\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Instant coffee powder\", \"quantity\": \"1 tbsp\"}, {\"ingredient\": \"Cocoa powder\", \"quantity\": \"2 tbsp\"}, {\"ingredient\": \"Mini dark chocolate chips\", \"quantity\": \"1/4 cup\"}]', '[\"Mix all ingredients.\", \"Form into balls.\", \"Chill.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(184, 'No-Bake Mango Cheesecake Cups', 'Fresh mango puree swirled into creamy cheesecake mousse.', 'No-Bake', 20, 0, 8, 'Medium', 'images/default.png', '[{\"ingredient\": \"Cream cheese\", \"quantity\": \"300g\"}, {\"ingredient\": \"Greek yogurt\", \"quantity\": \"1/2 cup\"}, {\"ingredient\": \"Stevia\", \"quantity\": \"1/3 cup\"}, {\"ingredient\": \"Vanilla extract\", \"quantity\": \"1 tsp\"}, {\"ingredient\": \"Mango puree\", \"quantity\": \"1 cup\"}]', '[\"Whip cream cheese and yogurt.\", \"Layer with mango puree.\", \"Chill.\"]', 'Mira Kadamani', '2025-04-21 10:32:30', 11),
(185, 'Coconut Chocolate Energy Bites', 'Easy no-bake treats packed with coconut, dark chocolate, and almonds — gluten-free, vegan, and no-bake!', 'Vegan, Gluten-Free, No-Bake', 15, 0, 15, 'Easy', 'images/default.png', '[{\"ingredient\":\"Almond flour\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Unsweetened shredded coconut\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Dark chocolate chips (sugar-free)\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Maple syrup\",\"quantity\":\"2 tbsp\"}]', '[\"Mix almond flour, shredded coconut, and chocolate chips.\",\"Add coconut oil and maple syrup, stir until combined.\",\"Roll into small balls.\",\"Chill for at least 1 hour before serving.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11),
(186, 'Lemon Berry Chia Pudding Parfaits', 'Refreshing, fruity, and completely egg-free, nut-free, and vegan-friendly parfaits!', 'Vegan, Nut-Free, Egg-Free', 10, 0, 4, 'Easy', 'images/default.png', '[{\"ingredient\":\"Chia seeds\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Unsweetened almond milk\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1 tbsp\"},{\"ingredient\":\"Lemon zest\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Fresh mixed berries\",\"quantity\":\"1 cup\"}]', '[\"Whisk chia seeds, almond milk, stevia, and lemon zest.\",\"Refrigerate for at least 4 hours.\",\"Layer chia pudding with fresh berries in glasses.\",\"Serve chilled.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11),
(187, 'Peanut Butter Banana Ice Cream', 'Creamy, decadent ice cream made with bananas and peanut butter — no added sugar, no bake!', 'No-Bake, Sugar-Free, High-Protein', 10, 0, 6, 'Medium', 'images/default.png', '[{\"ingredient\":\"Frozen ripe bananas\",\"quantity\":\"4\"},{\"ingredient\":\"Peanut butter (natural)\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Almond milk (optional)\",\"quantity\":\"2 tbsp\"}]', '[\"Blend frozen bananas until creamy.\",\"Add peanut butter and vanilla; blend again.\",\"If too thick, add almond milk to adjust consistency.\",\"Freeze for 1 hour before serving.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11),
(188, 'Avocado Chocolate Mousse', 'Rich and creamy chocolate mousse using avocado — totally vegan, diabetic-friendly, and nut-free!', 'Vegan, Diabetic-Friendly, Nut-Free', 15, 0, 4, 'Easy', 'images/default.png', '[{\"ingredient\":\"Ripe avocados\",\"quantity\":\"2\"},{\"ingredient\":\"Unsweetened cocoa powder\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Vanilla extract\",\"quantity\":\"1 tsp\"},{\"ingredient\":\"Coconut milk\",\"quantity\":\"2 tbsp\"}]', '[\"Blend avocados until completely smooth.\",\"Add cocoa powder, stevia, vanilla, and coconut milk.\",\"Blend again until creamy and rich.\",\"Chill and serve with berries if desired.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11),
(189, 'Sweet Potato Protein Bites', 'High-protein snack balls made with roasted sweet potatoes, oats, and protein powder — gluten-free, high-protein, egg-free!', 'High-Protein, Gluten-Free, Egg-Free', 20, 0, 12, 'Medium', 'images/default.png', '[{\"ingredient\":\"Cooked mashed sweet potato\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Oats (gluten-free)\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Protein powder (vanilla)\",\"quantity\":\"1/2 cup\"},{\"ingredient\":\"Peanut butter\",\"quantity\":\"2 tbsp\"},{\"ingredient\":\"Cinnamon\",\"quantity\":\"1 tsp\"}]', '[\"Mix sweet potato, oats, protein powder, peanut butter, and cinnamon.\",\"Roll into small balls.\",\"Chill for at least 30 minutes before eating.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11),
(190, 'No-Bake Blueberry Coconut Bars', 'Fruity, creamy coconut bars packed with blueberries — no baking, nut-free, vegan, and diabetic-friendly!', 'No-Bake, Nut-Free, Diabetic-Friendly', 20, 0, 8, 'Medium', 'images/default.png', '[{\"ingredient\":\"Unsweetened shredded coconut\",\"quantity\":\"2 cups\"},{\"ingredient\":\"Coconut cream\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Stevia\",\"quantity\":\"1/4 cup\"},{\"ingredient\":\"Blueberries\",\"quantity\":\"1 cup\"},{\"ingredient\":\"Coconut oil\",\"quantity\":\"2 tbsp\"}]', '[\"Mix shredded coconut, coconut cream, stevia, and coconut oil.\",\"Gently fold in blueberries.\",\"Press mixture into a lined baking dish.\",\"Chill for at least 2 hours, slice into bars, and serve.\"]', 'Mira Kadamani', '2025-04-21 10:40:20', 11);

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
(4, 'Yassine zeort', 'yassine.elzeort@lau.edu', '$2y$10$1KsoPGYI6CRj/Czp4xb3IOvGT.lngKoVf4BHk3mt9Jibx1YF9shjO', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(5, 'Mohammad Zeitoun', 'mohammad.zeitoun@lau.edu', '$2y$10$YZbdMJUEXJ4od3tvblc69.RKiY9ZWncC.T/75xq3FIEb1z.b0gtCu', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(6, 'Ahmad Sabra', 'ahmad.sabra@lau.edu', '$2y$10$KPth8wSgprY7S00J7uYjbO096aTeKf5I4fp/Ylm1AiP7E3J91tufa', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(7, 'Rawad Allam', 'rawad.allam@lau.edu', '$2y$10$ALI2p6i.h2NXHkkSLhIRheCnXKiOZAFpUmNch0t226GYnF0Cve6ly', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(8, 'Jad Arab', 'jad.arab@lau.edu', '$2y$10$0izMRl8gd1KmDBIUoOSN3.JoT5UUsriGO6XTUdfbWI3.aoUoGI7W2', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(9, 'Ranime Ibrahim', 'ranime.ibrahim@lau.edu', '$2y$10$rcCAIA0rJVuPEWE5ZaCCpOPhNHXQSbFD6L4qqhyNB.rC/MMY.EqvS', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(10, 'Ali Safeidine', 'Ali.safeidine@lau.edu', '$2y$10$2oN3RpJThaJo4EQmvuu.IuC8sE.hMXxpEwAnThKg0fihnEoeMgupO', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker'),
(11, 'Mira Kadamani', 'Mira.kadamani@lau.edu', '$2y$10$65bX31nRhy1g.2vpgJR1P.9z2bmJAG1NcxGOkezsCNgZJgrF665wC', 'images/default.png', 'No bio yet', 'Still looking for new hobbies...', 'Baker');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
