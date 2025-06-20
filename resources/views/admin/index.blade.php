<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('storage/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


</head>

<body>

    <div class="scroll-indicator" id="scrollProgress"></div>

    <!-- Navbar -->
    <nav class="navbarr" id="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <div class="user-avatar">
                    @if ($user->user_photo)
                        <img src="{{ asset('storage/' . $user->user_photo) }}" alt="User Photo" class="user-photo">
                    @else
                        <div class="no-photo">{{ substr($user->name, 0, 2) }}</div>
                    @endif
                </div>

                <div class="welcome-text">Welcome, {{ $user->name }}!</div>
            </div>

            <div class="nav-right">
                <a href="{{ route('logout') }}" class="logout-btn">
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-2">

        <div class="d-flex justify-content-between">
 
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-2" id="blogTab" role="tablist">
                @foreach ($categories as $id => $name)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab{{ $id }}" data-bs-toggle="tab"
                            data-bs-target="#cat{{ $id }}" type="button" role="tab">
                            {{ $name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            @auth
                <a href="{{ route('blogs.create') }}" class="btn mb-3"
                    style="background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white;">Add Blog</a>
            @endauth
        </div>

        <div class="d-flex gap-3 mb-3">

            <div class="d-flex flex-column " style="min-width: 60%;">

                <div class="tab-content" id="blogTabContent">
                    @foreach ($categories as $id => $name)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="cat{{ $id }}"
                            role="tabpanel">
                            @php $catBlogs = $blogs->where('category', $id); @endphp

                            @forelse ($catBlogs as $blog)
                                <div class="card mb-3">
                                    @if ($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top m-2"
                                            style="max-height: 200px; max-width: 200px; object-fit: fill;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <p class="card-text">{{ $blog->description }}</p>
                                        <p class="text-muted">By: {{ $blog->user->name }} |
                                            {{ $blog->created_at->format('d M Y') }}</p>


                                        {{-- Likes --}}
                                        <div>
                                            @php
                                                $user = auth()->user();
                                                $liked = $user && $user->hasLikedBlog($blog->id);
                                            @endphp

                                            <span class="like-icon" data-blog-id="{{ $blog->id }}"
                                                style="cursor: pointer; font-size: 24px; color: {{ $liked ? 'red' : '#999' }};">
                                                {{ $liked ? '❤️' : '🤍' }}
                                            </span>

                                            <span class="like-count" id="like-count-{{ $blog->id }}">
                                                {{ $blog->likes }} Likes
                                            </span>
                                            @auth
                                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Are you sure?')"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                
                                            @endauth
                                        </div>  

                                    </div>
                                </div>
                            @empty
                                <p>No blogs in this category.</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>

            </div>



            <div class="card p-3 mb-3" style="max-width: 40%;">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Alias minima, atque magnam impedit eos nostrum
                explicabo sapiente asperiores, suscipit ad enim obcaecati, quis molestiae voluptate quia autem commodi
                debitis velit earum sit eum. Suscipit quo eligendi dicta et accusantium illum eos sunt. Quisquam
                suscipit aliquam, molestiae atque error quod fuga!
            </div>

        </div>
    </div>



    <footer class="footer">
        <div class="container">
            <div class="row1">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        <li><a href="#">about us</a></li>
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">affiliate program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">shipping</a></li>
                        <li><a href="#">returns</a></li>
                        <li><a href="#">order status</a></li>
                        <li><a href="#">payment options</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>online shop</h4>
                    <ul>
                        <li><a href="#">watch</a></li>
                        <li><a href="#">bag</a></li>
                        <li><a href="#">shoes</a></li>
                        <li><a href="#">dress</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script>
        document.querySelectorAll('.like-icon').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const blogId = this.getAttribute('data-blog-id');
                const iconEl = this;
                const countEl = document.getElementById('like-count-' + blogId);

                fetch(`/blogs/${blogId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            iconEl.innerText = data.liked ? '❤️' : '🤍';
                            iconEl.style.color = data.liked ? 'red' : '#999';
                            countEl.innerText = `${data.likes} Likes`;
                        }
                    })
                    .catch(err => console.error('Error:', err));
            });
        });


        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            const scrollProgress = document.getElementById('scrollProgress');

            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Update scroll progress
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            scrollProgress.style.width = scrolled + '%';
        });

        // Handle logout (replace with your actual logout logic)
        function handleLogout() {
            // Add your logout logic here
            alert('Logout clicked! Replace this with your actual logout route.');
        }

        // Demo: Toggle between photo and no-photo state
        let hasPhoto = true;
        document.getElementById('userPhoto').addEventListener('click', function () {
            const container = this.parentElement;
            if (hasPhoto) {
                container.innerHTML = '<div class="no-photo">JD</div>';
                hasPhoto = false;
            } else {
                container.innerHTML = '<img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="User Photo" class="user-photo" id="userPhoto">';
                hasPhoto = true;
                // Re-attach click listener
                document.getElementById('userPhoto').addEventListener('click', arguments.callee);
            }
        });
    </script>
</body>

</html>