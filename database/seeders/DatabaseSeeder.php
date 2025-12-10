<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categoryNames = [
            'Appetizer',
            'Main Course',
            'Snack',
            'Dessert',
            'Coffee',
            'Non Coffee',
            'Healthy Juice',
        ];

        foreach ($categoryNames as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => Str::random(20),
            ]);
        }

        $foods = [
            [
                'name' => 'Grilled Chicken Salad',
                'category_id' => 1,
                'price' => 35000,
                'description' => 'Healthy grilled chicken with fresh vegetables.',
                'image' => 'foods/1grilledChickenSalad.jpg'
            ],
            [
                'name' => 'Bruschetta',
                'category_id' => 1,
                'price' => 28000,
                'description' => 'Toasted bread topped with tomatoes and basil.',
                'image' => 'foods/1bruschetta.jpg'
            ],
            [
                'name' => 'Garlic Bread',
                'category_id' => 1,
                'price' => 20000,
                'description' => 'Warm bread with garlic butter.',
                'image' => 'foods/1garlicBread.jpg'
            ],
            [
                'name' => 'Stuffed Mushrooms',
                'category_id' => 1,
                'price' => 32000,
                'description' => 'Mushrooms stuffed with cheese and herbs.',
                'image' => 'foods/1stuffedMushrooms.jpg'
            ],
            [
                'name' => 'Caprese Skewers',
                'category_id' => 1,
                'price' => 25000,
                'description' => 'Mini skewers of tomato, mozzarella, and basil.',
                'image' => 'foods/1capreseSkewers.jpg'
            ],
            [
                'name' => 'Spaghetti Carbonara',
                'category_id' => 2,
                'price' => 42000,
                'description' => 'Classic Italian pasta with creamy sauce.',
                'image' => 'foods/2spaghettiCarbonara.jpg'
            ],
            [
                'name' => 'Beef Lasagna',
                'category_id' => 2,
                'price' => 48000,
                'description' => 'Layered pasta with beef and melted cheese.',
                'image' => 'foods/2beefLasagna.jpg'
            ],
            [
                'name' => 'Chicken Teriyaki Bowl',
                'category_id' => 2,
                'price' => 39000,
                'description' => 'Chicken glazed with teriyaki sauce over rice.',
                'image' => 'foods/2chickenTeriyakiBowl.jpg'
            ],
            [
                'name' => 'Fish and Chips',
                'category_id' => 2,
                'price' => 45000,
                'description' => 'Crispy battered fish with fries.',
                'image' => 'foods/2fishAndChips.jpg'
            ],
            [
                'name' => 'Beef Steak with Gravy',
                'category_id' => 2,
                'price' => 55000,
                'description' => 'Tender steak with savory brown sauce.',
                'image' => 'foods/2beefSteakWithGravy.jpg'
            ],
            [
                'name' => 'Cheese Nachos',
                'category_id' => 3,
                'price' => 25000,
                'description' => 'Crispy nachos topped with melted cheese.',
                'image' => 'foods/3cheeseNachos.jpg'
            ],
            [
                'name' => 'French Fries',
                'category_id' => 3,
                'price' => 18000,
                'description' => 'Golden fried potato sticks.',
                'image' => 'foods/3frenchFries.jpg'
            ],
            [
                'name' => 'Spring Rolls',
                'category_id' => 3,
                'price' => 22000,
                'description' => 'Crispy vegetable-filled rolls.',
                'image' => 'foods/3springRolls.jpg'
            ],
            [
                'name' => 'Chicken Wings',
                'category_id' => 3,
                'price' => 30000,
                'description' => 'Spicy glazed chicken wings.',
                'image' => 'foods/3chickenWings.jpg'
            ],
            [
                'name' => 'Potato Wedges',
                'category_id' => 3,
                'price' => 23000,
                'description' => 'Seasoned wedges with dipping sauce.',
                'image' => 'foods/3potatoWedges.jpg'
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'category_id' => 4,
                'price' => 30000,
                'description' => 'Decadent chocolate cake with a molten center.',
                'image' => 'foods/4chocolateLavaCake.jpg'
            ],
            [
                'name' => 'Tiramisu',
                'category_id' => 4,
                'price' => 35000,
                'description' => 'Coffee-flavored Italian dessert.',
                'image' => 'foods/4tiramisu.jpg'
            ],
            [
                'name' => 'Panna Cotta',
                'category_id' => 4,
                'price' => 32000,
                'description' => 'Creamy vanilla dessert with fruit sauce.',
                'image' => 'foods/4pannaCotta.jpg'
            ],
            [
                'name' => 'Brownie Sundae',
                'category_id' => 4,
                'price' => 28000,
                'description' => 'Chocolate brownie with ice cream.',
                'image' => 'foods/4brownieSundae.jpg'
            ],
            [
                'name' => 'Fruit Tart',
                'category_id' => 4,
                'price' => 30000,
                'description' => 'Tart shell filled with custard and fresh fruit.',
                'image' => 'foods/4fruitTart.jpg'
            ],
            [
                'name' => 'Espresso',
                'category_id' => 5,
                'price' => 20000,
                'description' => 'Strong and rich coffee shot.',
                'image' => 'foods/5espresso.jpg'
            ],
            [
                'name' => 'Americano',
                'category_id' => 5,
                'price' => 22000,
                'description' => 'Espresso with hot water.',
                'image' => 'foods/5americano.jpg'
            ],
            [
                'name' => 'Cappuccino',
                'category_id' => 5,
                'price' => 25000,
                'description' => 'Coffee with steamed milk and foam.',
                'image' => 'foods/5cappuccino.jpg'
            ],
            [
                'name' => 'Latte',
                'category_id' => 5,
                'price' => 26000,
                'description' => 'Smooth blend of espresso and milk.',
                'image' => 'foods/5latte.jpg'
            ],
            [
                'name' => 'Mocha',
                'category_id' => 5,
                'price' => 28000,
                'description' => 'Chocolate-flavored coffee.',
                'image' => 'foods/5mocha.jpg'
            ],
            [
                'name' => 'Iced Matcha Latte',
                'category_id' => 6,
                'price' => 28000,
                'description' => 'Refreshing matcha latte served cold.',
                'image' => 'foods/6icedMatchaLatte.jpg'
            ],
            [
                'name' => 'Hot Chocolate',
                'category_id' => 6,
                'price' => 25000,
                'description' => 'Creamy hot cocoa drink.',
                'image' => 'foods/6hotChocolate.jpg'
            ],
            [
                'name' => 'Chai Latte',
                'category_id' => 6,
                'price' => 27000,
                'description' => 'Spiced tea with milk.',
                'image' => 'foods/6thaiTea.jpg'
            ],
            [
                'name' => 'Vanilla Milkshake',
                'category_id' => 6,
                'price' => 30000,
                'description' => 'Creamy vanilla-flavored shake.',
                'image' => 'foods/6vanillaMilkshake.jpg'
            ],
            [
                'name' => 'Thai Tea',
                'category_id' => 6,
                'price' => 24000,
                'description' => 'Sweet tea with condensed milk.',
                'image' => 'foods/6thaiTea.jpg'
            ],
            [
                'name' => 'Fruit Smoothie Bowl',
                'category_id' => 7,
                'price' => 30000,
                'description' => 'Refreshing smoothie with mixed fruits and granola.',
                'image' => 'foods/7fruitSmoothieBowl.jpg'
            ],
            [
                'name' => 'Detox Green Juice',
                'category_id' => 7,
                'price' => 28000,
                'description' => 'Blend of green veggies and fruits.',
                'image' => 'foods/7detoxGreenJuice.jpg'
            ],
            [
                'name' => 'Beetroot Juice',
                'category_id' => 7,
                'price' => 26000,
                'description' => 'Earthy and sweet beetroot drink.',
                'image' => 'foods/7beetrootJuice.jpg'
            ],
            [
                'name' => 'Carrot Orange Juice',
                'category_id' => 7,
                'price' => 27000,
                'description' => 'Vitamin-rich carrot and orange blend.',
                'image' => 'foods/7carrotOrangeJuice.jpg'
            ],
            [
                'name' => 'Pineapple Ginger Shot',
                'category_id' => 7,
                'price' => 22000,
                'description' => 'Small but powerful immune booster.',
                'image' => 'foods/7pineappleGingerShot.jpg'
            ],
        ];

        foreach ($foods as $food) {
            Food::create([
                'name' => $food['name'],
                'category_id' => $food['category_id'],
                'price' => $food['price'],
                'description' => $food['description'],
                'image' => $food['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        User::factory(10)->create();

        User::create([
            'name' => 'Admin DeliGreen',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('masuk12345'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Kantor Pusat DeliGreen',
            'email_verified_at' => now(),
        ]);

        $userIds = User::pluck('id')->toArray();

        Order::factory()
            ->count(25)
            ->has(OrderItem::factory()->count(3), 'items')
            ->create([
                'user_id' => fake()->randomElement($userIds),
            ])
            ->each(function ($order) {
                foreach ($order->items as $item) {
                    $item->update(['user_id' => $order->user_id]);
                    $item->update([
                        'order_type' => fake()->boolean(50) ? 0 : 1,
                    ]);
                }

                $order->update([
                    'total_price' => $order->items->sum(fn($i) => $i->price * $i->quantity),
                ]);
            });
    }
}
