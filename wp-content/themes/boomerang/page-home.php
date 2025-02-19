<?php
/**
 * Template Name: Boomerang Home
 */

get_header(); ?>

<main class="home-page">
    <!-- Banner -->
    <section class="banner">
        <div class="container">
            <h1>Приветственный Бонус</h1>
            <p class="promo-text">100% ДО €50</p>
            <a href="#" class="register-btn">Зарегистрируйтесь</a>
        </div>
    </section>

    <!-- Search Bar -->
    <section class="search-container">
        <input type="text" placeholder="Поиск">
        <button class="search-btn">🔍</button>
    </section>

    <!-- Filters -->
    <section class="filters">
        <button>🔥 Топ</button>
        <button>✨ Новые</button>
        <button>⭐ Популярные</button>
        <button>🎁 Эксклюзив</button>
        <button>🛍 Бонусные Покупки</button>
        <button>🎰 Слоты</button>
        <button>🎥 Лайв Казино</button>
        <button>👑 Мегавэйс</button>
    </section>

    <!-- Slots Grid -->
    <section class="slots">
        <h2>Топ Слот</h2>
        <div class="slots-grid">

        </div>
    </section>
</main>

<?php get_footer(); ?>
