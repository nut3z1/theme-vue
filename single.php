<?php
/**
 * Template: Bài viết chi tiết (Single Post)
 *
 * @package VueCommerce
 */

get_header();
?>

<main id="vue-main" class="min-h-screen">
    <?php while (have_posts()) : the_post(); ?>

    <article class="relative">
        <!-- Hero Image -->
        <?php if (has_post_thumbnail()) : ?>
        <div class="relative h-[40vh] md:h-[50vh] overflow-hidden">
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'hero-banner'); ?>" 
                 alt="<?php the_title_attribute(); ?>"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-dark-900/60 to-transparent"></div>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 <?php echo has_post_thumbnail() ? '-mt-32 relative z-10' : 'pt-16'; ?>">
            <!-- Meta -->
            <div class="mb-6 flex flex-wrap items-center gap-3 text-sm text-dark-400">
                <time datetime="<?php echo get_the_date('c'); ?>" class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <?php echo get_the_date(); ?>
                </time>
                <span>•</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <?php the_author(); ?>
                </span>
                <?php
                $categories = get_the_category();
                if ($categories) :
                ?>
                <span>•</span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
                <?php endif; ?>
            </div>

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark-50 mb-8 leading-tight">
                <?php the_title(); ?>
            </h1>

            <!-- Post Content -->
            <div class="prose prose-invert prose-lg max-w-none 
                        prose-headings:font-display prose-headings:text-dark-50
                        prose-a:text-primary-400 prose-a:no-underline hover:prose-a:text-primary-300
                        prose-img:rounded-2xl prose-img:shadow-lg
                        prose-blockquote:border-primary-500 prose-blockquote:bg-dark-800/50 prose-blockquote:rounded-r-xl prose-blockquote:py-1
                        prose-code:text-secondary-400 prose-code:bg-dark-800 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded-md
                        prose-pre:bg-dark-800 prose-pre:border prose-pre:border-dark-700 prose-pre:rounded-2xl">
                <?php the_content(); ?>
            </div>

            <!-- Tags -->
            <?php
            $tags = get_the_tags();
            if ($tags) :
            ?>
            <div class="mt-12 pt-8 border-t border-dark-700">
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo get_tag_link($tag->term_id); ?>" 
                       class="px-4 py-1.5 text-sm bg-dark-800 text-dark-300 rounded-full hover:bg-primary-500/20 hover:text-primary-400 transition-colors border border-dark-700">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Navigation -->
            <nav class="mt-12 pt-8 border-t border-dark-700 grid grid-cols-1 md:grid-cols-2 gap-6 pb-16">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <?php if ($prev_post) : ?>
                <a href="<?php echo get_permalink($prev_post); ?>" 
                   class="group p-6 bg-dark-800/50 rounded-2xl border border-dark-700 hover:border-primary-500/50 transition-all">
                    <span class="text-sm text-dark-400 group-hover:text-primary-400 transition-colors">← Bài trước</span>
                    <p class="mt-2 text-dark-100 font-medium group-hover:text-dark-50 transition-colors line-clamp-2">
                        <?php echo get_the_title($prev_post); ?>
                    </p>
                </a>
                <?php else : ?>
                <div></div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo get_permalink($next_post); ?>" 
                   class="group p-6 bg-dark-800/50 rounded-2xl border border-dark-700 hover:border-primary-500/50 transition-all text-right">
                    <span class="text-sm text-dark-400 group-hover:text-primary-400 transition-colors">Bài tiếp →</span>
                    <p class="mt-2 text-dark-100 font-medium group-hover:text-dark-50 transition-colors line-clamp-2">
                        <?php echo get_the_title($next_post); ?>
                    </p>
                </a>
                <?php endif; ?>
            </nav>
        </div>
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
