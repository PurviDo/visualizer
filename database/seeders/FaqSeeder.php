<?php

namespace Database\Seeders;

use App\Models\Cms\Faq;
use App\Models\Cms\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the tables
        Faq::truncate();
        FaqCategory::truncate();

        // Create categories
        $categories = [
            'General Queries' => FaqCategory::create(['name' => 'General Queries']),
            'Price related' => FaqCategory::create(['name' => 'Price related']),
            'Refund related' => FaqCategory::create(['name' => 'Refund related']),
            'Software related' => FaqCategory::create(['name' => 'Software related']),
        ];

        // Create FAQs
        $faqs = [
            [
                'name' => 'What is CamClo3D?',
                'description' => '<p>CamClo3D is a digital draping software. This means, you can have a flat fabric image/design and you can see how it will look draped as a kurta/kurti/shirt etc. You can also upload flat images of sarees and have them draped onto models within seconds!</p>',
                'category_id' => $categories['General Queries']->id
            ],
            [
                'name' => 'How is CamClo3D useful for my ecommerce business?',
                'description' => '<p>In this day and age of increasing competition online, all companies are constantly fighting to get the best images out. Many surveys have shown how the customers respond better to modeled clothes, since they are able to visualize the clothes better. CamClo3D helps you model your clothes, without the hassle of getting an expensive photoshoot done every time you get new stock. With our software, you not only save money but time too!</p>',
                'category_id' => $categories['General Queries']->id
            ],
            [
                'name' => 'Can I use CamClo3D even if I have little/no technical knowledge?',
                'description' => '<p>CamClo3D has been developed keeping in mind small business owners who are trying to sell their wares online. Hence, you do not require much technical knowledge. Our UI/UX is very user friendly - making it easy for you to render your images within seconds.</p>',
                'category_id' => $categories['General Queries']->id
            ],
            [
                'name' => 'How long does it take to get the modeled images in CamClo3D?',
                'description' => '<p>Depending on how many fabrics you upload, you can get your rendered images on different templates almost immediately!</p>',
                'category_id' => $categories['General Queries']->id
            ],

            // Price related
            [
                'name' => 'How much is CamClo3D?',
                'description' => '<p>Starting from Rs.5000 to Rs.10000, you get 100 credits to 300 credits to use our software where 1 credit = 1 image.</p>',
                'category_id' => $categories['Price related']->id
            ],
            [
                'name' => 'I have a small business - do you have any plans for me?',
                'description' => '<p>We offer three tiers for subscription - based on different amounts of drapes that you might need in the form of credits. You can choose the Bronze plan for a smaller scale of business where you need only a few drapes.</p>',
                'category_id' => $categories['Price related']->id
            ],
            [
                'name' => 'Can I have a trial before purchasing the software?',
                'description' => '<p>Absolutely! You can check out our free trial here and get 10 drapes for absolutely free, with a watermark. Once satisfied, you can then purchase the software to remove any watermarks.</p>',
                'category_id' => $categories['Price related']->id
            ],

            // Refund related
            [
                'name' => 'What is your refund policy?',
                'description' => '<p>At the moment, since we are a SaaS company, we have a strict no-refund policy. If you want to try out the software before purchasing, you can check out our trial version here.</p>',
                'category_id' => $categories['Refund related']->id
            ],

            // Software related
            [
                'name' => 'Do I get any training for using the software?',
                'description' => '<p>We have created extensive tutorials to make your onboarding process easier. You can check out our videos here. However, if you would wish to receive training, please get in touch and drop us an email at: support@camclo3d.com</p>',
                'category_id' => $categories['Software related']->id
            ],
            [
                'name' => 'I require a unique model face for my brand that nobody else has. Is that possible?',
                'description' => '<p>Yes! Please get in touch with us for the same. You can get a unique model face for your brand, which will not be used by any other clients. This service is available at a one time fee of INR 2,000/- for reserving a unique face provided by us, plus INR 200/template you wish to apply the face on. Please do keep in mind that only the face of the model changes, the pose remains the same.</p>',
                'category_id' => $categories['Software related']->id
            ],
            [
                'name' => 'Can I give my own templates for the software?',
                'description' => '<p>We offer custom solutions to brands based on your requirements. We would be happy to look into creating custom templates for you. Please get in touch via email at: support@camclo3d.com</p>',
                'category_id' => $categories['Software related']->id
            ],
            [
                'name' => 'How long do I have the credits for?',
                'description' => '<p>The credits are only valid for 6 months from the date of purchase. You are advised to make use of these credits before the end of their validity and only purchase as per your requirements.</p>',
                'category_id' => $categories['Software related']->id
            ],
            [
                'name' => 'How long do you store the rendered images?',
                'description' => '<p>All images are available for 30 days on the server. After that, the images are automatically deleted from the servers.</p>',
                'category_id' => $categories['Software related']->id
            ],
            [
                'name' => 'How long do you store the uploaded fabric images?',
                'description' => '<p>All fabric images uploaded by you are available for 2 days on the server. After that, the images are automatically deleted from the servers. You may re-upload the fabric images in order to make use of it again.</p>',
                'category_id' => $categories['Software related']->id
            ],
            // Add more FAQs for other categories...
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
