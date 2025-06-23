@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    @section('togglebtn')
        <a href="{{ route('admin.users') }}" class="logout-btn">
            <span>View User's</span>
        </a>
    @endsection

    
    <div class="scroll-indicator" id="scrollProgress"></div>


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
                                        <p class="text-muted">By: {{ $blog->user->name }} |
                                            {{ $blog->created_at->format('d M Y') }}
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

    </script>
@endpush