<?php get_header(); ?>

<h1>Все слоты</h1>

<form method="GET">
    <input type="text" name="search" placeholder="Поиск..." value="<?php echo esc_attr($_GET['search'] ?? ''); ?>" />
    <button type="submit">Поиск</button>
</form>

<div class="slots-list">
    <?php
    $search = $_GET['search'] ?? '';
    $args = [
        'post_type' => 'slot',
        'posts_per_page' => -1,
        's' => $search
    ];
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="slot">
                <h2><?php the_title(); ?></h2>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
            </div>
        <?php endwhile;
    else :
        echo '<p>Слотов не найдено.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
