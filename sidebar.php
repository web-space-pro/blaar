<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blaar
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<section class="mt-5 mb-5 *:mb-5">
    <div class="container">
        <aside class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="space-y-6">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div>
            <?php else : ?>
                <div class="p-4 bg-white dark:bg-gray-700 rounded">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Сайдбар</h2>
                    <p class="text-gray-600 dark:text-gray-400">Добавьте виджеты в админке.</p>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</section>
