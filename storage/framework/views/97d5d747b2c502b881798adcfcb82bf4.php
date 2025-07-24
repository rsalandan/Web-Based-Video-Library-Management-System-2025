

<?php $__env->startSection('admin'); ?>
    <style>
        .video-player {
            width: 100%;
            max-height: 40vh;
            object-fit: contain;
            background-color: #2c3e50;
        }

        .video-wrapper {
            background: #3e4e5c;
            padding: 0;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Layout for top row */
        .top-row {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .video-container {
            flex: 1 1 70%;
            min-width: 300px;
        }

        .recent-play-container {
            background: #3e4e5c;
            /* matches side panels */
            border-radius: 8px;
            padding: 10px;
            max-height: 40vh;
            overflow-y:

        }

        .recent-play-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 10px;
            padding: 6px;
            border-radius: 6px;
            background: #2c3e50;
            text-decoration: none;
            color: #999999;
            transition: box-shadow 0.2s ease-in-out;
        }

        .recent-play-item:hover {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
        }

        .recent-play-thumb {
            width: 80px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .recent-play-title {
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-grow: 1;
        }

        /* Reviews and content below video */
        .video-info {
            margin-top: 1rem;
        }

        .review-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            border-radius: 6px;
        }
    </style>

    <div class="container-fluid px-4">
        <!-- Back Button -->
        <div class="row mb-0">
            <div class="col"><br>
                <h4 class="header-title">Video Player</h4>
                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-info waves-effect waves-light" title="Dashboard">
                        <i class="fe-skip-back"></i>
                    </a>
                    <a href="<?php echo e(route('video.index')); ?>" class="btn btn-blue waves-effect waves-light" title="Video Library">
                        <i class="fas fa-list"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Top row: Video + Recent Plays -->
        <div class="top-row">
            <div class="video-container">
                <div class="video-wrapper">
                    <video id="video-player" controls autoplay poster="<?php echo e(asset($video->thumbnail)); ?>" class="video-player">
                        <source src="<?php echo e(asset($video->video)); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="recent-play-container">
                <h5>Recent Plays</h5>
                <?php if($recentPlays->count()): ?>
                    <?php $__currentLoopData = $recentPlays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="recent-play-item-wrapper mb-3">
                            <a href="<?php echo e(route('video.show', $recent->id)); ?>"
                                class="recent-play-item d-flex align-items-start">
                                <img src="<?php echo e(asset($recent->thumbnail)); ?>" alt="<?php echo e($recent->title); ?>"
                                    class="recent-play-thumb me-2">
                                <div>
                                    <div class="recent-play-title"><?php echo e($recent->title); ?></div>
                                    <div class="recent-play-category"><?php echo e($recent->category->name); ?></div>
                                    <div class="recent-play-meta text-sm text-muted mt-1">
                                        <span class="ms-2" id="likes-count"><?php echo e($recent->likes()->count()); ?> likes</span>
                                        <span class="views-count" data-views="<?php echo e($recent->views); ?>">
                                            &nbsp;&middot;&nbsp; <?php echo e(number_format($recent->views)); ?> views
                                            &nbsp;&middot;&nbsp; <?php echo e($recent->reviews()->count()); ?> comments
                                            
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p>No recent videos played.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Video Title, Description, Likes, Views -->
        <div class="video-info">
            <h5>
                <p class="mb-0"><?php echo e($video->title); ?> || <?php echo e($video->category->name ?? 'N/A'); ?></p>
            </h5>
            <p class="card-text mt-1"><?php echo e($video->description); ?></p>

            <div class="mb-2">
                <?php if(auth()->guard()->check()): ?>
                    <span id="like-button" style="cursor: pointer; user-select: none;">
                        <i class="fas fa-heart"></i>
                        <span id="like-text">
                            <?php echo e($video->likes()->where('user_id', auth()->id())->exists()? 'Unlike': 'Like'); ?>

                        </span>
                    </span>
                <?php endif; ?>
                <span id="likes-count" class="ms-2 text-muted"><?php echo e($video->likes()->count()); ?> likes</span>
                <span class="views-count" data-views="<?php echo e($video->views); ?>">
                    &nbsp;&middot;&nbsp; <?php echo e(number_format($video->views)); ?> views
                    &nbsp;&middot;&nbsp;<?php echo e($video->reviews()->count()); ?> comments &nbsp;&middot;&nbsp;
                    <?php echo e($video->created_at->diffForHumans()); ?>

                </span>
            </div>

            <!-- Reviews Section -->
            <div class="mt-0">
                <h6>Reviews:</h6>
                <?php $__empty_1 = true; $__currentLoopData = $video->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border rounded p-2 mb-2 bg-light d-flex justify-content-between align-items-start">
                        <div>
                            <strong><?php echo e($review->user->name); ?></strong> rated:
                            <span class="text-warning"><?php echo e(str_repeat('★', $review->rating)); ?></span>
                            <small class="text-muted">(<?php echo e($review->rating); ?>/5 •
                                <?php echo e($review->created_at->diffForHumans()); ?>)</small>
                            <p class="mb-0"><?php echo e($review->comment); ?></p>
                        </div>

                        <?php if(Auth::check() && (Auth::id() === $review->user_id || Auth::user()->role_id == 1)): ?>
                            <div class="dropdown ms-auto">
                                <a class="btn btn-sm btn-light dropdown-toggle p-0 fs-5" href="#" role="button"
                                    id="reviewDropdown-<?php echo e($review->id); ?>" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="Actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="reviewDropdown-<?php echo e($review->id); ?>">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item"
                                            onclick="openEditModal(<?php echo e($review->id); ?>, '<?php echo e(addslashes($review->comment)); ?>', <?php echo e($review->rating); ?>)"
                                            title="Update Review">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <form id="delete-review-form-<?php echo e($review->id); ?>"
                                            action="<?php echo e(route('reviews.destroy', $review->id)); ?>" method="POST"
                                            class="m-0">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="dropdown-item text-danger"
                                                onclick="confirmDeleteReview(<?php echo e($review->id); ?>)" title="Delete Review">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Update Review Modal -->
                            <form id="edit-review-form-<?php echo e($review->id); ?>" method="POST"
                                action="<?php echo e(route('reviews.update', $review->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="modal fade" id="editReviewModal-<?php echo e($review->id); ?>" tabindex="-1"
                                    aria-labelledby="editReviewModalLabel-<?php echo e($review->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editReviewModalLabel-<?php echo e($review->id); ?>">
                                                    Update
                                                    Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-label">Your Rating:</label>
                                                <div id="edit-star-rating-<?php echo e($review->id); ?>"
                                                    class="star-rating text-warning fs-5 mb-1" style="cursor: pointer;">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <i class="far fa-star" data-value="<?php echo e($i); ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <label class="form-label">Comment:</label>
                                                <textarea name="comment" id="editComment-<?php echo e($review->id); ?>" class="form-control" rows="4" required></textarea>
                                                <input type="hidden" name="rating" id="editRating-<?php echo e($review->id); ?>"
                                                    required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Review</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">No reviews yet.</p>
                <?php endif; ?>
            </div>

            
            <?php if(Auth::check()): ?>
                <form action="<?php echo e(route('reviews.store')); ?>" method="POST" class="mt-2">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="video_id" value="<?php echo e($video->id); ?>">
                    <div class="mb-1">
                        <label class="form-label">Your Rating:</label>
                        <div id="star-rating-<?php echo e($video->id); ?>" class="star-rating text-warning fs-5"
                            style="cursor: pointer;">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="far fa-star" data-value="<?php echo e($i); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating-<?php echo e($video->id); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="comment" class="form-label">Comment:</label>
                        <textarea name="comment" rows="2" class="form-control form-control-sm" placeholder="Write a comment..."
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Submit Review</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Confirm delete with SweetAlert2
        function confirmDeleteReview(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the review permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-review-form-' + id).submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Star rating for new review form
            document.querySelectorAll(".star-rating").forEach(function(ratingContainer) {
                const stars = ratingContainer.querySelectorAll("i");
                stars.forEach(function(star) {
                    star.addEventListener("click", function() {
                        const rating = this.getAttribute("data-value");
                        const hiddenInput = ratingContainer.parentElement.querySelector(
                            "input[name='rating']");
                        if (hiddenInput) hiddenInput.value = rating;
                        stars.forEach(function(s, i) {
                            if (i < rating) {
                                s.classList.remove("far");
                                s.classList.add("fas");
                            } else {
                                s.classList.remove("fas");
                                s.classList.add("far");
                            }
                        });
                    });
                });
            });

            // Star rating for edit modals
            document.querySelectorAll("[id^='edit-star-rating-']").forEach(function(ratingContainer) {
                const stars = ratingContainer.querySelectorAll("i");
                const reviewId = ratingContainer.id.replace('edit-star-rating-', '');
                const hiddenInput = document.getElementById(`editRating-${reviewId}`);

                function updateStars(rating) {
                    stars.forEach((star, i) => {
                        if (i < rating) {
                            star.classList.remove("far");
                            star.classList.add("fas");
                        } else {
                            star.classList.remove("fas");
                            star.classList.add("far");
                        }
                    });
                }

                stars.forEach(function(star) {
                    star.addEventListener("click", function() {
                        const rating = parseInt(this.getAttribute("data-value"));
                        hiddenInput.value = rating;
                        updateStars(rating);
                    });
                });
            });

            // Video view tracking (once per page load)
            const video = document.getElementById('video-player');
            if (video) {
                video.addEventListener('play', function() {
                    fetch('<?php echo e(route('video.trackView', $video->id)); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log("View counted");
                            } else {
                                console.error("Failed to count view");
                            }
                        })
                        .catch(error => {
                            console.error("Error counting view:", error);
                        });
                }, {
                    once: true
                });
            }
        });

        // Open edit modal and pre-fill rating & comment
        function openEditModal(reviewId, comment, rating = 0) {
            document.getElementById(`editComment-${reviewId}`).value = comment;

            const hiddenInput = document.getElementById(`editRating-${reviewId}`);
            hiddenInput.value = rating;

            // Update star visuals
            const stars = document.querySelectorAll(`#edit-star-rating-${reviewId} i`);
            stars.forEach((star, i) => {
                if (i < rating) {
                    star.classList.remove("far");
                    star.classList.add("fas");
                } else {
                    star.classList.remove("fas");
                    star.classList.add("far");
                }
            });

            var modal = new bootstrap.Modal(document.getElementById(`editReviewModal-${reviewId}`));
            modal.show();
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const likeButton = document.getElementById("like-button");
            const likesCount = document.getElementById("likes-count");
            const likeText = document.getElementById("like-text");

            if (likeButton) {
                likeButton.addEventListener("click", function() {
                    fetch('<?php echo e(route('video.like', $video->id)); ?>', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            likeButton.classList.toggle("btn-outline-danger", !data.liked);
                            likeButton.classList.toggle("btn-danger", data.liked);
                            likeText.textContent = data.liked ? 'Unlike' : 'Like';
                            likesCount.textContent = `${data.likes_count} likes`;
                        })
                        .catch(error => console.error("Error:", error));
                });
            }
        });
    </script>

    
    <div class="footer py-1 bg-light text-center mt-4">
        <div class="container">
            &copy; <?php echo e(date('Y')); ?> Your Company. All rights reserved.
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\MAMP\htdocs\Web-Based Video Library Management System 2025\resources\views/backend/video/show.blade.php ENDPATH**/ ?>