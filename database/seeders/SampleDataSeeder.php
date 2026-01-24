<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelPackage;
use App\Models\Blog;
use App\Models\FAQ;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding sample travel packages...');
        $this->seedTravelPackages();

        $this->command->info('Seeding sample blog posts...');
        $this->seedBlogPosts();

        $this->command->info('Seeding sample FAQs...');
        $this->seedFAQs();

        $this->command->info('Sample data seeded successfully!');
    }

    private function seedTravelPackages()
    {
        $packages = [
            [
                'title' => 'Paris Romantic Getaway',
                'description' => 'Experience the city of love with our 5-day Paris package including Eiffel Tower, Louvre Museum, and romantic Seine river cruise.',
                'destination' => 'Paris, France',
                'duration_days' => 5,
                'price' => 2999.99,
                'discount_price' => 2499.99,
                'inclusions' => ['Round-trip flights', '4-star hotel', 'Daily breakfast', 'City tours', 'Museum entries'],
                'exclusions' => ['Lunch and dinner', 'Travel insurance', 'Personal expenses'],
                'itinerary' => 'Day 1: Arrival & Eiffel Tower\nDay 2: Louvre Museum\nDay 3: Versailles Palace\nDay 4: Seine River Cruise\nDay 5: Shopping & Departure',
                'max_travelers' => 15,
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(2)->addDays(5),
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Tokyo Adventure',
                'description' => 'Discover the fusion of traditional and modern Japan in this exciting 7-day Tokyo adventure.',
                'destination' => 'Tokyo, Japan',
                'duration_days' => 7,
                'price' => 3299.99,
                'inclusions' => ['Round-trip flights', '3-star hotel', 'Daily breakfast', 'JR Pass', 'Mt. Fuji tour'],
                'exclusions' => ['Travel insurance', 'Personal expenses'],
                'itinerary' => 'Day 1: Arrival in Tokyo\nDay 2: Shibuya & Shinjuku\nDay 3: Mt. Fuji Day Trip\nDay 4: Traditional Kyoto\nDay 5: Osaka\nDay 6: Disney Tokyo\nDay 7: Departure',
                'max_travelers' => 20,
                'start_date' => Carbon::now()->addMonths(3),
                'end_date' => Carbon::now()->addMonths(3)->addDays(7),
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Dubai Luxury Experience',
                'description' => 'Indulge in the ultimate luxury experience in Dubai with our premium package.',
                'destination' => 'Dubai, UAE',
                'duration_days' => 4,
                'price' => 4499.99,
                'inclusions' => ['Business class flights', '5-star hotel', 'All meals', 'Desert safari', 'Burj Khalifa access'],
                'exclusions' => ['Travel insurance', 'Shopping expenses'],
                'itinerary' => 'Day 1: Arrival & Check-in\nDay 2: Desert Safari\nDay 3: City Tour & Shopping\nDay 4: Burj Khalifa & Departure',
                'max_travelers' => 10,
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(1)->addDays(4),
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($packages as $package) {
            TravelPackage::create($package);
        }
    }

    private function seedBlogPosts()
    {
        $blogs = [
            [
                'title' => 'Top 10 Travel Destinations for 2024',
                'slug' => 'top-10-travel-destinations-2024',
                'excerpt' => 'Discover the most exciting travel destinations that should be on your bucket list for 2024.',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Travel in 2024 promises exciting adventures across the globe. From the beaches of Bali to the mountains of Switzerland, there\'s something for every type of traveler. Our curated list includes hidden gems and popular destinations that offer unique experiences.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => true,
                'views' => 1234,
                'tags' => ['travel', 'destinations', '2024', 'tips'],
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Student Visa Guide: Everything You Need to Know',
                'slug' => 'student-visa-guide-everything-you-need-to-know',
                'excerpt' => 'A comprehensive guide to help students navigate the complex visa application process.',
                'content' => 'Applying for a student visa can be overwhelming, but with the right guidance, the process becomes manageable. This guide covers everything from document preparation to interview tips. Learn about common mistakes to avoid and essential requirements for different countries.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => false,
                'views' => 856,
                'tags' => ['visa', 'student', 'education', 'guide'],
                'published_at' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'Budget Travel Tips for Backpackers',
                'slug' => 'budget-travel-tips-for-backpackers',
                'excerpt' => 'Travel the world without breaking the bank with these essential budget travel tips.',
                'content' => 'Backpacking offers an incredible way to see the world on a budget. Learn how to save money on accommodation, food, and transportation while still having amazing experiences. From hostel hopping to local street food, discover the secrets of budget travel.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => false,
                'views' => 2341,
                'tags' => ['budget', 'backpacking', 'tips', 'savings'],
                'published_at' => Carbon::now()->subDays(21),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog + ['author_id' => 1]);
        }
    }

    private function seedFAQs()
    {
        $faqs = [
            [
                'question' => 'How long does it take to process a visa application?',
                'answer' => 'Visa processing times vary by country and type, but typically range from 2-8 weeks. We recommend applying at least 2-3 months before your intended travel date to allow for any delays.',
                'category' => 'visa',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What documents are required for student visa application?',
                'answer' => 'Required documents typically include: passport valid for 6+ months, acceptance letter from educational institution, proof of financial support, academic transcripts, and language proficiency test results.',
                'category' => 'admission',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'How do I cancel my booking?',
                'answer' => 'Bookings can be cancelled through your dashboard. Cancellation policies vary by package, but generally allow free cancellation up to 30 days before departure. Late cancellations may incur fees.',
                'category' => 'travel',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'What does a consultation service include?',
                'answer' => 'Our consultation service includes personalized guidance on visa applications, university admissions, career counseling, and travel planning. Sessions are typically 1-hour and can be conducted in person or virtually.',
                'category' => 'consultation',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Do you offer group discounts?',
                'answer' => 'Yes! We offer group discounts for bookings of 5 or more travelers. Discounts range from 10-20% depending on group size and destination. Contact our team for custom group packages.',
                'category' => 'general',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }
    }
}