@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

    <div class="container mt-2">

        <div class="d-flex justify-content-between">

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
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="cat{{ $id }}" role="tabpanel">
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
                                        <p class="text-muted">
                                            Posted by <strong>{{ $blog->user->name }}</strong> on
                                            {{ $blog->created_at->format('d M Y, h:i A') }}
                                        </p>


                                        {{-- Likes --}}
                                        <div class="d-flex flex-row justify-content-between align-items-center">
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
                                            </div>    
                                            <div>
                                                @auth
                                                    @if (Auth::id() === $blog->user_id)
                                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="mt-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">Delete Blog</button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
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



@endsection


@push('scripts')
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

@endpush