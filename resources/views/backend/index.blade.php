@extends('backend.admin_dashboard')
@section('admin')
    @php
        use App\Models\User;
        use App\Models\Video;
        use App\Models\Category;
        use App\Models\Review;
        use App\Models\VideoLike;
        $totalAdmins = User::where('role_id', 1)->where('name', '!=', 'Super Admin')->count();
        $totalUsers = User::where('role_id', 5)->count();
        $totalVideoViews = Video::sum('views'); // counts total video views
        $totalVideoComments = Review::whereNotNull('comment')->count(); // ✔ total comments for all videos
        $totalVideoLikes = VideoLike::count();
        $totalVideos = Video::count();
        $topViewedVideos = Video::withCount('viewers') // counts/id total views
            ->withAvg('reviews', 'rating') // calculates average rating
            ->with('category') // loads category
            ->orderByDesc('viewers_count') // sort by most views
            ->take(4)
            ->get();
    @endphp

    <div class="content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range"></i>
                                    </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                    <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- summary cards -->
            <div class="row">
                <!-- Total Stocks -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success border-primary border shadow">
                                        <i class="fe-user-check font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalAdmins) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Active Admins</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Requests -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-primary border-success border shadow">
                                        <i class="fe-user font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalUsers) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Active Users</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning border-info border shadow">
                                        <i class="fe-video font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalVideos) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Total Videos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Requests -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-info border-warning border shadow">
                                        <i class="fe-eye font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalVideoViews) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Total Video Views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger border-info border shadow">
                                        <i class="fe-heart font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalVideoLikes) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Total Video Likes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Requests -->
                <div class="col-md-6 col-xl-4">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-secondary border-warning border shadow">
                                        <i class="fe-message-square font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{ number_format($totalVideoComments) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">Total Video Comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top 3 Rated Videos (Rank 1 ➝ 3) -->
                <div class="row mt-0">
                    <div class="col-12">
                        <h4 class="text-info mb-3">🏆 Top 4 Most Viewed Videos (Ranked Highest to Lowest)</h4>
                        <div class="row">
                            @foreach ($topViewedVideos as $video)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-60 border-primary shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <a href="{{ route('video.show', $video->id) }}">
                                                <div class="ratio ratio-16x9 mb-0">
                                                    <video controls poster="{{ asset($video->thumbnail) }}">
                                                        <source src="{{ asset($video->video) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-between mb-0">
                                                <h5 class="page-title mb-0">
                                                    <p class="mb-0">
                                                        <strong><span
                                                                class="badge bg-success me-1">#{{ $loop->iteration }}</span></strong>
                                                        {{ number_format($video->views) }} views &nbsp;&middot;&nbsp;
                                                        {{ $video->likes()->count() }} likes
                                                        &nbsp;&middot;&nbsp;{{ $video->reviews()->count() }} comments
                                                    </p>
                                                </h5>
                                                <h5 class="page-title mb-0">
                                                    {{ $video->created_at->diffForHumans() }}
                                                </h5>
                                            </div>
                                            <div class="d-flex justify-content-between mb-0">
                                            </div>
                                            <p class="card-text mt-1 mb-0">
                                                Avg Rating:
                                                @if ($video->reviews_avg_rating)
                                                    @php
                                                        $avg = number_format($video->reviews_avg_rating, 1);
                                                        $fullStars = str_repeat('★', floor($avg));
                                                        $emptyStars = str_repeat('☆', 5 - floor($avg));
                                                    @endphp
                                                    <span
                                                        class="text-warning">{{ $fullStars }}</span>{{ $emptyStars }}
                                                    ({{ $avg }}/5)
                                                @else
                                                    No ratings yet
                                                @endif
                                            </p>
                                            <p class="card-text mt-0 mb-0">
                                                {{ $video->title }} || {{ $video->category->name ?? 'N/A' }}</p>
                                            <p class="card-text tiny-spacing fw-semibold">
                                                <a href="{{ route('video.show', $video->id) }}" style="color: #abb2b9;">
                                                    {{ Str::limit($video->description, 50) }}
                                                </a>
                                                <a href="{{ route('video.show', $video->id) }}" style="color: #abb2b9;"
                                                    class="button-primary-trans mouse-dir">
                                                    See more
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- end summary cards row -->
        @endsection
