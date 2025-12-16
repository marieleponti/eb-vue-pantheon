<?php
if (! defined('ABSPATH')) {
	die('Direct access forbidden.');
}
?>
<?php
$filters_data = get_filters_data();
?>
<div lang='en' id="primary filter-section-container eb-mn-contenedor-exterior-seccion-filtros-busqueda">
	<inforepo-search class="inforepo-search filters-row px-4 eb-mn-seccion-busqueda">

		<div class="buscador">
			<div>
				<input type="text" class="form-control" aria-label="search" name="buscar" id="buscar" placeholder="key terms" />
			</div>
			<div class="filter-buttons-container">
			<button class="filter-section-button filter-button" id="inforepo-search-submit" type="submit" value="search" name="search-button">
				<?php echo esc_html__( 'Search', 'inforepo' ); ?>
			</button>
			<button class="filter-section-button filter-button" id="inforepo-clear-filters" type="submit" value="clear" name="clear">
				<?php echo esc_html__( 'Clear', 'inforepo' ); ?>
			</button>
			<button class="filter-section-button filter-button"
                id="map-view-button" type="submit"
                value="mapview"
                name="map-view-button">
				<?php echo esc_html__( 'Map View', 'inforepo' ); ?>            
			</button>
			</div>
		
		</div>
		<!-- <div class="buscador">
			<?php
			// get_search_form(); 
			?>
			<button class="w-30 btn btn-md btn-dark btn-custom-color btn-filter-search" id="inforepo-search-submit" type="submit" value="search" name="search">Search</button>
		</div> -->
		<inforepo-filters class="col-lg-3 col-md-3 col-sm-12 pb-4">
			<!-- Taxonomy1: Topic -->
			<?php $topic = $filters_data[0] ?>
			<inforepo-checkbox-accordion name="taxonomy-name" id="taxonomy-name" class="checkbox-accordion" key="<?php echo esc_html($topic['slug'] ?? '', 'inforepo'); ?>" label="<?php echo esc_attr($topic['label'] ?? '', 'inforepo'); ?>">
				<?php if (!empty($topic['label'])) : ?>
					<div class="checkbox-accordion__handle" role="button">
						<div class="checkbox-accordion__handle-text"><?php echo esc_html($topic['label'], 'inforepo'); ?></div>
						<span class="checkbox-accordion__handle-icon"></span>
					</div>
				<?php endif; ?>

				<inforepo-checkbox-accordion-content class="checkbox-accordion__content">
					<?php foreach ($topic['children'] as $item) : ?>
						<?php
						$has_children      = !empty($item['children']) && is_array($item['children']);
						$has_content_class = !empty($has_children) ? 'checkbox-accordion__child--has-content' : '';
						?>
						<!--Level One - Children-->
						<?php if (!empty($item['label'])) : ?>
							<inforepo-checkbox-accordion-child class="checkbox-accordion__child">
								<div class="checkbox-accordion__child-handle form-field">
									<label data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox">
										<?php $topic_terms = []; ?>

										<input type="checkbox" class="term-checkbox" name="topic-terms[]" id="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											type="checkbox" data-key-term="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" value="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>"
											parent-taxonomy="<?php echo esc_attr($topic['slug'] ?? '', 'inforepo'); ?>"
											<?php if (!empty($has_children)) : ?> data-has-children="true" <?php endif; ?>>

										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-text"><?php echo wp_kses_post($item['label']); ?></span>
									</label>
									<?php if (!empty($has_children)) : ?>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											class="checkbox-accordion__lvl-one-icon checkbox-accordion__child-handle-icon"></span>
									<?php endif; ?>
								</div>
							</inforepo-checkbox-accordion-child>
						<?php endif; ?>
					<?php endforeach; ?>
				</inforepo-checkbox-accordion-content>
			</inforepo-checkbox-accordion>

			<!-- End Taxonomy1: Topic -->


			<!-- Taxonomy2: Source -->
			<?php $source = $filters_data[1] ?>
			<inforepo-checkbox-accordion name="taxonomy-name" id="taxonomy-name" class="checkbox-accordion" key="<?php echo esc_attr($source['slug'] ?? '', 'inforepo'); ?>"
				label="<?php echo esc_attr($source['label'] ?? '', 'inforepo'); ?>">
				<?php if (!empty($source['label'])) : ?>
					<div class="checkbox-accordion__handle" role="button">
						<div class="checkbox-accordion__handle-text"><?php echo esc_html($source['label'], 'inforepo'); ?></div>
						<span class="checkbox-accordion__handle-icon"></span>
					</div>
				<?php endif; ?>

				<inforepo-checkbox-accordion-content class="checkbox-accordion__content">
					<?php foreach ($source['children'] as $item) : ?>
						<?php
						$has_children      = !empty($item['children']) && is_array($item['children']);
						$has_content_class = !empty($has_children) ? 'checkbox-accordion__child--has-content' : '';
						?>
						<!--Level One - Children-->
						<?php if (!empty($item['label'])) : ?>
							<inforepo-checkbox-accordion-child class="checkbox-accordion__child">
								<div class="checkbox-accordion__child-handle form-field">
									<label data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox">
										<input type="checkbox" class="term-checkbox" name="source-terms[]" id="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											type="checkbox" data-key-term="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" value="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>"
											parent-taxonomy="<?php echo esc_attr($source['slug'] ?? '', 'inforepo'); ?>"
											<?php if (!empty($has_children)) : ?> data-has-children="true" <?php endif; ?>>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-text"><?php echo wp_kses_post($item['label']); ?>
										</span>
									</label>
									<?php if (!empty($has_children)) : ?>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-accordion__lvl-one-icon checkbox-accordion__child-handle-icon"></span>
									<?php endif; ?>
								</div>
							</inforepo-checkbox-accordion-child>
						<?php endif; ?>
					<?php endforeach; ?>
				</inforepo-checkbox-accordion-content>
			</inforepo-checkbox-accordion>
			<!-- End Taxonomy2: Source -->

			<!-- Taxonomy3: Format -->
			<?php $format = $filters_data[2] ?>
			<inforepo-checkbox-accordion name="taxonomy-name" id="taxonomy-name" class="checkbox-accordion" key="<?php echo esc_attr($format['slug'] ?? '', 'inforepo'); ?>"
				label="<?php echo esc_attr($format['label'] ?? '', 'inforepo'); ?>">
				<?php if (!empty($format['label'])) : ?>
					<div class="checkbox-accordion__handle" role="button">
						<div class="checkbox-accordion__handle-text"><?php echo esc_html($format['label'], 'inforepo'); ?></div>
						<span class="checkbox-accordion__handle-icon"></span>
					</div>
				<?php endif; ?>

				<inforepo-checkbox-accordion-content class="checkbox-accordion__content">
					<?php foreach ($format['children'] as $item) : ?>
						<?php
						$has_children      = !empty($item['children']) && is_array($item['children']);
						$has_content_class = !empty($has_children) ? 'checkbox-accordion__child--has-content' : '';
						?>
						<!--Level One - Children-->
						<?php if (!empty($item['label'])) : ?>
							<inforepo-checkbox-accordion-child class="checkbox-accordion__child">
								<div class="checkbox-accordion__child-handle form-field">
									<label data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox">
										<input type="checkbox" class="term-checkbox" name="format-terms[]" id="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											type="checkbox" data-key-term="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" value="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>"
											parent-taxonomy="<?php echo esc_attr($format['slug'] ?? '', 'inforepo'); ?>"
											<?php if (!empty($has_children)) : ?> data-has-children="true" <?php endif; ?>>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-text"><?php echo wp_kses_post($item['label']); ?>
										</span>
									</label>
									<?php if (!empty($has_children)) : ?>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-accordion__lvl-one-icon checkbox-accordion__child-handle-icon"></span>
									<?php endif; ?>
								</div>
							</inforepo-checkbox-accordion-child>
						<?php endif; ?>
					<?php endforeach; ?>
				</inforepo-checkbox-accordion-content>
			</inforepo-checkbox-accordion>

			<!-- end Taxonomy3: Format -->

			<!-- Taxonomy4: Countries -->
			<?php $country = $filters_data[3] ?>
			<inforepo-checkbox-accordion name="taxonomy-name" id="taxonomy-name" class="checkbox-accordion" key="<?php echo esc_attr($country['slug'] ?? '', 'inforepo'); ?>"
				label="<?php echo esc_attr($country['label'] ?? '', 'inforepo'); ?>">
				<?php if (!empty($country['label'])) : ?>
					<div class="checkbox-accordion__handle" role="button">
						<div class="checkbox-accordion__handle-text"><?php echo esc_html($country['label'], 'inforepo'); ?></div>
						<span class="checkbox-accordion__handle-icon"></span>
					</div>
				<?php endif; ?>

				<inforepo-checkbox-accordion-content class="checkbox-accordion__content">
					<?php foreach ($country['children'] as $item) : ?>
						<?php
						$has_children      = !empty($item['children']) && is_array($item['children']);
						$has_content_class = !empty($has_children) ? 'checkbox-accordion__child--has-content' : '';
						?>
						<!--Level One - Children-->
						<?php if (!empty($item['label'])) : ?>
							<inforepo-checkbox-accordion-child class="checkbox-accordion__child">
								<div class="checkbox-accordion__child-handle form-field">
									<label data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox">
										<input type="checkbox" class="term-checkbox" name="country-terms[]" id="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											type="checkbox" data-key-term="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" value="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>"
											parent-taxonomy="<?php echo esc_attr($country['slug'] ?? '', 'inforepo'); ?>"
											<?php if (!empty($has_children)) : ?> data-has-children="true" <?php endif; ?>>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-text"><?php echo wp_kses_post($item['label']); ?>
										</span>
									</label>
									<?php if (!empty($has_children)) : ?>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-accordion__lvl-one-icon checkbox-accordion__child-handle-icon"></span>
									<?php endif; ?>
								</div>
							</inforepo-checkbox-accordion-child>
						<?php endif; ?>
					<?php endforeach; ?>
				</inforepo-checkbox-accordion-content>
			</inforepo-checkbox-accordion>

			<!-- end Taxonomy4: Country -->

			<!-- Taxonomy5: Language -->
			<?php $language = $filters_data[4] ?>
			<inforepo-checkbox-accordion name="taxonomy-name" id="taxonomy-name" class="checkbox-accordion" key="<?php echo esc_attr($language['slug'] ?? '', 'inforepo'); ?>"
				label="<?php echo esc_attr($language['label'] ?? '', 'inforepo'); ?>">
				<?php if (!empty($language['label'])) : ?>
					<div class="checkbox-accordion__handle" role="button">
						<div class="checkbox-accordion__handle-text"><?php echo esc_html($language['label'], 'inforepo'); ?></div>
						<span class="checkbox-accordion__handle-icon"></span>
					</div>
				<?php endif; ?>

				<inforepo-checkbox-accordion-content class="checkbox-accordion__content">
					<?php foreach ($language['children'] as $item) : ?>
						<?php
						$has_children      = !empty($item['children']) && is_array($item['children']);
						$has_content_class = !empty($has_children) ? 'checkbox-accordion__child--has-content' : '';
						?>
						<!--Level One - Children-->
						<?php if (!empty($item['label'])) : ?>
							<inforepo-checkbox-accordion-child class="checkbox-accordion__child">
								<div class="checkbox-accordion__child-handle form-field">
									<label data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox">
										<input type="checkbox" class="term-checkbox" name="language-terms[]" id="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>"
											type="checkbox" data-key-term="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>" value="<?php echo esc_attr($item['slug'] ?? '', 'inforepo'); ?>"
											parent-taxonomy="<?php echo esc_attr($language['slug'] ?? '', 'inforepo'); ?>"
											<?php if (!empty($has_children)) : ?> data-has-children="true" <?php endif; ?>>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-text"><?php echo wp_kses_post($item['label']); ?>
										</span>
									</label>
									<?php if (!empty($has_children)) : ?>
										<span data-text="<?php echo esc_attr($item['label'], 'inforepo'); ?>" class="checkbox-accordion__lvl-one-icon checkbox-accordion__child-handle-icon"></span>
									<?php endif; ?>
								</div>
							</inforepo-checkbox-accordion-child>
						<?php endif; ?>
					<?php endforeach; ?>
				</inforepo-checkbox-accordion-content>
			</inforepo-checkbox-accordion>

			<!-- end Taxonomy5: Language -->


		</inforepo-filters>
		<button class="filter-button filter-section-button" id="inforepo-search-submit" type="submit" value="search" name="search-button">
			<?php echo esc_html__( 'Search', 'inforepo' ); ?>
		</button>
	</inforepo-search>
</div> <!-- primary -->