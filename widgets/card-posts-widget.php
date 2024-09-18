<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Alucard0x1_Card_Posts_Widget extends Widget_Base {

    public function get_name() {
        return 'alucard0x1-card-posts';
    }

    public function get_title() {
        return __( 'Alucard0x1 Card Posts', 'alucard0x1-card-posts' );
    }

    public function get_icon() {
        return 'eicon-posts-ticker';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'alucard0x1-card-posts' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'desktop_posts',
            [
                'label' => __( 'Posts to Show on Desktop', 'alucard0x1-card-posts' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'tablet_posts',
            [
                'label' => __( 'Posts to Show on Tablet', 'alucard0x1-card-posts' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'mobile_posts',
            [
                'label' => __( 'Posts to Show on Mobile', 'alucard0x1-card-posts' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'total_posts',
            [
                'label' => __( 'Total Posts to Render', 'alucard0x1-card-posts' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $desktop_posts = $settings['desktop_posts'];
        $tablet_posts  = $settings['tablet_posts'];
        $mobile_posts  = $settings['mobile_posts'];
        $total_posts   = $settings['total_posts'];

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => $total_posts,
            'post_status'    => 'publish',
        ];

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) :
            $unique_id = 'alucard0x1-card-container-' . $this->get_id();
            ?>
            <div class="alucard0x1--card-container" id="<?php echo esc_attr($unique_id); ?>">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                        $post_link = get_permalink();
                        $post_title = get_the_title();
                        $post_excerpt = get_the_excerpt();
                        $author_id = get_the_author_meta( 'ID' );
                        $author_name = get_the_author();
                        $author_avatar = get_avatar_url( $author_id, ['size' => 36] );
                        $post_date = get_the_date();
                        $categories = get_the_category();
                        $category_name = ! empty( $categories ) ? esc_html( $categories[0]->name ) : '';
                    ?>
                    <a href="<?php echo esc_url( $post_link ); ?>" class="alucard0x1--card-link" aria-label="<?php echo esc_attr( $post_title ); ?>">
                        <div class="alucard0x1--card">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <img src="<?php the_post_thumbnail_url( 'medium' ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" class="alucard0x1--card-image">
                            <?php endif; ?>
                            <div class="alucard0x1--content">
                                <h2><?php echo esc_html( $post_title ); ?></h2>
                                <p><?php echo wp_trim_words( $post_excerpt, 20, '...' ); ?></p>
                                <div class="alucard0x1--footer">
                                    <div class="alucard0x1--author">
                                        <img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>">
                                        <div>
                                            <div class="alucard0x1--name"><?php echo esc_html( $author_name ); ?></div>
                                            <div class="alucard0x1--date"><?php echo esc_html( $post_date ); ?></div>
                                        </div>
                                    </div>
                                    <div class="alucard0x1--category"><?php echo esc_html( $category_name ); ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <style>
                #<?php echo esc_attr($unique_id); ?> {
                    display: grid;
                    grid-template-columns: repeat(<?php echo esc_attr($desktop_posts); ?>, 1fr);
                    gap: 34px;
                    padding: 0;
                }

                @media (max-width: 1024px) {
                    #<?php echo esc_attr($unique_id); ?> {
                        grid-template-columns: repeat(<?php echo esc_attr($tablet_posts); ?>, 1fr);
                    }
                }

                @media (max-width: 768px) {
                    #<?php echo esc_attr($unique_id); ?> {
                        grid-template-columns: repeat(<?php echo esc_attr($mobile_posts); ?>, 1fr);
                    }
                }

                .alucard0x1--card-link {
                    text-decoration: none;
                    color: inherit;
                    display: block;
                }

                .alucard0x1--card-link:hover .alucard0x1--card,
                .alucard0x1--card-link:focus .alucard0x1--card {
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    transform: translateY(-2px);
                    transition: all 0.3s ease;
                }

                .alucard0x1--card-link:focus {
                    outline: none;
                }

                .alucard0x1--card {
                    width: 100%;
                    font-family: "Segoe UI", Arial, sans-serif;
                    background: #fff;
                    border: 1px solid #d3d3d3;
                    border-radius: 8px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    margin: 0;
                    transition: box-shadow 0.3s ease, transform 0.3s ease;
                }

                .alucard0x1--card-image {
                    width: 100%;
                    height: 207px !important;
                    object-fit: cover;
                    display: block;
                }

                .alucard0x1--content {
                    padding: 20px;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }

                .alucard0x1--content h2 {
                    margin: 0 0 10px;
                    font-size: 16px;
                    color: #333;
                }

                .alucard0x1--content p {
                    margin: 0 0 16px;
                    font-size: 14px;
                    color: #666;
                    line-height: 1.4;
                }

                .alucard0x1--footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: baseline;
                    padding-top: 12px;
                    font-size: 12px;
                }

                .alucard0x1--author {
                    display: flex;
                    align-items: center;
                }

                .alucard0x1--author img {
                    width: 36px;
                    height: 36px;
                    border-radius: 50% !important;
                    margin-right: 8px;
                }

                .alucard0x1--name {
                    font-weight: bold;
                    color: #333;
                }

                .alucard0x1--date {
                    color: #555;
                }

                .alucard0x1--category {
                    color: #e74c3c;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 14px;
                    margin-top: 2px;
                }

                @media (max-width: 1024px) {
                    .alucard0x1--card-container {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 34px;
                    }
                }

                @media (max-width: 768px) {
                    .alucard0x1--card-container {
                        grid-template-columns: 1fr;
                        gap: 34px;
                    }
                }
            </style>

            <?php
            wp_reset_postdata();
        endif;
    }

    protected function content_template() {
    }
}
