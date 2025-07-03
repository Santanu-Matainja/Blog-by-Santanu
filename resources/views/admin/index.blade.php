<x-app-layout>

    <div class="container mx-auto mt-2 p-4">

        <div class="flex justify-between items-center flex-wrap gap-3">

            <!-- Tabs -->
            <ul class="flex border-b mb-2" id="blogTab" role="tablist">
                @foreach ($categories as $id => $name)
                    <li role="presentation" class="mr-2">
                        <button
                            class="py-2 px-4 text-sm font-medium border-b-2 transition-all duration-300 {{ $loop->first ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-blue-500 hover:border-blue-500' }}"
                            id="tab{{ $id }}" data-tab-target="#cat{{ $id }}" type="button"
                            role="tab">
                            {{ $name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            @auth
                <a href="{{ route('blogs.create') }}" class="mb-3 px-4 py-2 rounded text-white text-sm font-semibold shadow"
                    style="background: linear-gradient(135deg, #ff6b6b, #ee5a52);">
                    Add Blog
                </a>
            @endauth
        </div>

        <!-- Modal -->
        <div id="confirm-modal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Deletion</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this blog? This action cannot be undone.
                </p>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>

                    <button id="confirm-delete-button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 mb-3">

            <!-- Blog list -->
            <div class="flex flex-col w-full lg:w-[60%]">
                <div class="tab-content" id="blogTabContent">
                    @foreach ($categories as $id => $name)
                        <div class="tab-pane {{ $loop->first ? 'block' : 'hidden' }}" id="cat{{ $id }}"
                            role="tabpanel">
                            @php $catBlogs = $blogs->where('category', $id); @endphp

                            @forelse ($catBlogs as $blog)
                                <div class="bg-white border rounded shadow mb-4 overflow-hidden">
                                    @if ($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="object-cover m-2"
                                            style="max-height: 200px; max-width: 200px;">
                                    @endif

                                    <div class="p-4">
                                        <h5 class="text-xl font-bold">{{ $blog->title }}</h5>
                                        <p class="text-gray-700">{{ $blog->description }}</p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            By: <strong>{{ $blog->user->name }}</strong> |
                                            {{ $blog->created_at->format('d M Y') }}
                                        </p>

                                        <!-- Likes + Actions -->
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

                                            <div class="flex items-center gap-2">
                                                @auth
                                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                                        class="bg-yellow-400 hover:bg-yellow-500 text-black text-xs px-3 py-1 rounded">
                                                        Edit
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <button type="button"
                                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded"
                                                        onclick="openDeleteModal({{ $blog->id }})">
                                                        Delete
                                                    </button>

                                                    <!-- Hidden Form -->
                                                    <form id="delete-form-{{ $blog->id }}"
                                                        action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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

            <!-- Side Card -->
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
            document.querySelectorAll('.like-icon').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    const blogId = this.getAttribute('data-blog-id');
                    const iconEl = this;
                    const countEl = document.getElementById('like-count-' + blogId);

                    fetch(`/blogs/${blogId}/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
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


            document.addEventListener("DOMContentLoaded", function() {
                const tabButtons = document.querySelectorAll('[data-tab-target]');
                const tabPanes = document.querySelectorAll('.tab-pane');

                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const target = button.getAttribute('data-tab-target');

                        tabButtons.forEach(btn => {
                            btn.classList.remove('border-blue-500', 'text-blue-500');
                            btn.classList.add('text-gray-500', 'border-transparent');
                        });

                        button.classList.add('border-blue-500', 'text-blue-500');
                        button.classList.remove('text-gray-500', 'border-transparent');

                        tabPanes.forEach(pane => {
                            pane.classList.add('hidden');
                            pane.classList.remove('block');
                        });

                        const activePane = document.querySelector(target);
                        activePane.classList.remove('hidden');
                        activePane.classList.add('block');
                    });
                });
            });


            // tailwind model 

            let deleteFormId = null;

            function openDeleteModal(blogId) {
                deleteFormId = 'delete-form-' + blogId;
                document.getElementById('confirm-modal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('confirm-modal').classList.add('hidden');
                deleteFormId = null;
            }

            document.getElementById('confirm-delete-button').addEventListener('click', function() {
                if (deleteFormId) {
                    document.getElementById(deleteFormId).submit();
                }
            });
        </script>
    @endpush

</x-app-layout>
