<div class="comment" id="comment-{{ $comment->id }}">
    <div class="comment-header">
        <img src="{{ $comment->user->avatar ?? '/api/placeholder/50/50' }}" alt="{{ $comment->user->name }}" class="comment-img">
        <div class="comment-meta">
            <div class="comment-name">
                {{ $comment->user->name }}
                @if($comment->user_id == $article->user_id)
                <span class="badge bg-accent-custom ms-2">Author</span>
                @endif
            </div>
            <div class="comment-date">{{ $comment->created_at->format('F d, Y') }}</div>
        </div>
    </div>
    <div class="comment-content">
        <p>{{ $comment->content }}</p>
    </div>
    <div class="comment-actions mt-2">
        <a href="#" class="me-3 comment-like" data-comment-id="{{ $comment->id }}">
            <i class="far fa-thumbs-up me-1"></i> Like ({{ $comment->likes_count ?? 0 }})
        </a>
        <a href="#" class="comment-reply-btn" data-comment-id="{{ $comment->id }}">
            <i class="far fa-reply me-1"></i> Reply
        </a>
    </div>
    
    <!-- Reply Form (hidden by default) -->
    <div class="reply-form mt-3" id="reply-form-{{ $comment->id }}" style="display: none;">
        <textarea class="form-control reply-textarea" rows="2" placeholder="Write a reply..."></textarea>
        <div class="d-flex justify-content-end mt-2">
            <button class="btn btn-sm btn-secondary me-2 cancel-reply" data-comment-id="{{ $comment->id }}">Cancel</button>
            <button class="btn btn-sm btn-accent-custom submit-reply" data-comment-id="{{ $comment->id }}" data-article-id="{{ $article->id }}">Reply</button>
        </div>
    </div>
    
    <!-- Comment Replies -->
    <div class="comment-replies" id="replies-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
        <div class="comment-reply mt-3" id="comment-{{ $reply->id }}">
            <div class="comment-header">
                <img src="{{ $reply->user->avatar ?? '/api/placeholder/50/50' }}" alt="{{ $reply->user->name }}" class="comment-img">
                <div class="comment-meta">
                    <div class="comment-name">
                        {{ $reply->user->name }}
                        @if($reply->user_id == $article->user_id)
                        <span class="badge bg-accent-custom ms-2">Author</span>
                        @endif
                    </div>
                    <div class="comment-date">{{ $reply->created_at->format('F d, Y') }}</div>
                </div>
            </div>
            <div class="comment-content">
            <p>{{ $reply->content }}</p>
            </div>
            <div class="comment-actions mt-2">
                <a href="#" class="me-3 comment-like" data-comment-id="{{ $reply->id }}">
                    <i class="far fa-thumbs-up me-1"></i> Like ({{ $reply->likes_count ?? 0 }})
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>