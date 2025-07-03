<x-app-layout>

    <div class="container mx-auto mt-2 p-4">

    <div class="flex justify-between items-center flex-wrap gap-3">

        <ul class="flex border-b mb-2" id="blogTab" role="tablist">
            @foreach ($categories as $id => $name)
                <li class="mr-2" role="presentation">
                    <button class="py-2 px-4 text-sm font-medium border-b-2 transition-all duration-300 {{ $loop->first ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500 hover:border-blue-500' }}"
                        id="tab{{ $id }}" data-tab-target="#cat{{ $id }}" type="button" role="tab">
                        {{ $name }}
                    </button>
                </li>
            @endforeach
        </ul>

        @auth
            <a href="{{ route('blogs.create') }}"
                class="mb-3 px-4 py-2 rounded text-white text-sm font-semibold shadow"
                style="background: linear-gradient(135deg, #ff6b6b, #ee5a52);">
                Add Blog
            </a>
        @endauth
    </div>

    <div class="flex flex-col lg:flex-row gap-4 mb-3">

        <div class="flex flex-col w-full lg:w-[60%]">
            <div class="tab-content" id="blogTabContent">
                @foreach ($categories as $id => $name)
                    <div class="tab-pane {{ $loop->first ? 'block' : 'hidden' }}" id="cat{{ $id }}" role="tabpanel">
                        @php $catBlogs = $blogs->where('category', $id); @endphp

                        @forelse ($catBlogs as $blog)
                            <div class="bg-white border rounded shadow mb-4">
                                @if ($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}"
                                        class="m-2 object-cover"
                                        style="max-height: 200px; max-width: 200px;">
                                @endif
                                <div class="p-4">
                                    <h5 class="text-xl font-bold">{{ $blog->title }}</h5>
                                    <p class="text-gray-700">{{ $blog->description }}</p>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Posted by <strong>{{ $blog->user->name }}</strong> on
                                        {{ $blog->created_at->format('d M Y, h:i A') }}
                                    </p>

                                    {{-- Likes and Delete --}}
                                    <div class="flex justify-between items-center mt-4">
                                        <div>
                                            @php
                                                $user = auth()->user();
                                                $liked = $user && $user->hasLikedBlog($blog->id);
                                            @endphp

                                            <span class="like-icon cursor-pointer text-2xl"
                                                data-blog-id="{{ $blog->id }}"
                                                style="color: {{ $liked ? 'red' : '#999' }};">
                                                {{ $liked ? '❤️' : '🤍' }}
                                            </span>

                                            <span class="like-count text-sm text-gray-600 ml-1"
                                                id="like-count-{{ $blog->id }}">
                                                {{ $blog->likes }} Likes
                                            </span>
                                        </div>

                                        <div>
                                            @auth
                                                @if (Auth::id() === $blog->user_id)
                                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded"
                                                            onclick="return confirm('Are you sure?')">
                                                            Delete Blog
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No blogs in this category.</p>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-[40%] bg-white p-4 rounded shadow">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Alias minima, atque magnam impedit eos nostrum
            explicabo sapiente asperiores, suscipit ad enim obcaecati, quis molestiae voluptate quia autem commodi
            debitis velit earum sit eum. Suscipit quo eligendi dicta et accusantium illum eos sunt. Quisquam
            suscipit aliquam, molestiae atque error quod fuga!
        </div>

    </div>
</div>


    
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
         document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll('[data-tab-target]');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-tab-target');

                // Remove active styling from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-500');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Add active styling to current button
                button.classList.add('border-blue-500', 'text-blue-500');
                button.classList.remove('text-gray-500', 'border-transparent');

                // Hide all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                    pane.classList.remove('block');
                });

                // Show the target tab pane
                const activePane = document.querySelector(target);
                activePane.classList.remove('hidden');
                activePane.classList.add('block');
            });
        });
    });
    </script>

@endpush

</x-app-layout>
