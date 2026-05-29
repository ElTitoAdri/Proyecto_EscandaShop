<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Message;
use App\Models\ProductImage;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClients = User::where('role', '!=', 'admin')->count();
        $totalProducts = Product::count();

        // Calculate total revenue from orders
        $totalRevenue = Order::sum('total_price');
        $totalOrders = Order::count();

        // Products with stock < 5
        $lowStockCount = Product::where('stock', '<', 5)->count();

        // Latest orders
        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Pending orders count
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalClients',
            'totalProducts',
            'totalRevenue',
            'totalOrders',
            'lowStockCount',
            'latestOrders',
            'pendingOrders'
        ));
    }

    public function products()
    {
        $products = Product::with(['category', 'images'])->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.products', compact('products', 'categories'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories', compact('categories'));
    }

    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->get();

        return view('admin.orders', compact('orders'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $slug = Str::slug($request->name);

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_visible' => $request->has('is_visible'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $path,
                'is_primary' => true,
            ]);
        } elseif ($request->filled('image_url')) {
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $request->image_url,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('admin.products')->with('success', 'Producto creado correctamente.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $slug = Str::slug($request->name);

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_visible' => $request->has('is_visible'),
        ]);

        if ($request->hasFile('image')) {
            // Delete old primary image if exists
            $oldImage = $product->images()->where('is_primary', true)->first() ?? $product->images()->first();
            if ($oldImage) {
                if (!Str::startsWith($oldImage->url, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($oldImage->url);
                }
                $oldImage->delete();
            }

            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $path,
                'is_primary' => true,
            ]);
        } elseif ($request->filled('image_url')) {
            // Update or create primary image
            $oldImage = $product->images()->where('is_primary', true)->first() ?? $product->images()->first();
            if ($oldImage) {
                if (!Str::startsWith($oldImage->url, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($oldImage->url);
                }
                $oldImage->delete();
            }

            ProductImage::create([
                'product_id' => $product->id,
                'url' => $request->image_url,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('admin.products')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroyProduct(Product $product)
    {
        // Delete associated images from disk
        foreach ($product->images as $image) {
            if (!Str::startsWith($image->url, ['http://', 'https://'])) {
                Storage::disk('public')->delete($image->url);
            }
        }
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Producto eliminado correctamente.');
    }

    public function toggleProductVisibility(Product $product)
    {
        $product->update([
            'is_visible' => !$product->is_visible
        ]);

        return back()->with('success', 'Visibilidad del producto actualizada.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Categoría creada correctamente.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Categoría eliminada correctamente.');
    }

    public function users()
    {
        $users = User::withCount('orders')->orderByDesc('created_at')->get();

        return view('admin.users', compact('users'));
    }

    public function messages()
    {
        $messages = Message::with('user')->latest()->get();

        return view('admin.messages', compact('messages'));
    }

    public function destroyMessage(Message $message)
    {
        $message->delete();

        return back()->with('success', 'Mensaje eliminado correctamente.');
    }

    public function settings()
    {
        // Load settings from a simple JSON file or use defaults
        $settingsPath = storage_path('app/settings.json');
        $settings = file_exists($settingsPath)
            ? json_decode(file_get_contents($settingsPath), true)
            : [];

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = [
            'hero_title' => $request->input('hero_title', ''),
            'hero_subtitle' => $request->input('hero_subtitle', ''),
            'contact_email' => $request->input('contact_email', ''),
            'contact_phone' => $request->input('contact_phone', ''),
        ];

        $settingsPath = storage_path('app/settings.json');
        file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Configuración guardada correctamente.');
    }

    public function reviews()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();

        // Calculate statistics
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating') ?: 0;
        $pendingCount = $reviews->where('is_approved', false)->count();
        $approvedCount = $reviews->where('is_approved', true)->count();

        return view('admin.reviews', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'pendingCount',
            'approvedCount'
        ));
    }

    public function toggleReviewApproval(Review $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        return back()->with('success', $review->is_approved 
            ? 'Reseña aprobada correctamente y visible en la tienda.' 
            : 'Reseña ocultada de la tienda correctamente.');
    }

    public function destroyReview(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Reseña eliminada correctamente.');
    }
}
