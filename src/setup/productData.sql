-- =====================================================
-- ATHLETIQ DATABASE SEED
-- =====================================================
--
-- Product ID Ranges:
--   Women's: 1-25
--   Men's:   26-50
--
-- Variant ID Formula:
--   (product_id * 100) + size_sequence
--
-- Clothing Size Sequence:
--   XS=1, S=2, M=3, L=4, XL=5
--
-- Women's Footwear (UK 3-9):
--   3=1, 4=2, 5=3, 6=4, 7=5, 8=6, 9=7
--
-- Men's Footwear (UK 5-12):
--   5=1, 6=2, 7=3, 8=4, 9=5, 10=6, 11=7, 12=8
--

-- -----------------------------------------------------
-- BASE CATEGORIES (FORCED IDS)
-- -----------------------------------------------------

DELETE FROM category WHERE category_id BETWEEN 1 AND 12;

INSERT INTO category (category_id, name, description, parent_category_id) VALUES
(1, 'Women', 'Women''s sportswear and athletic clothing', NULL),
(2, 'Men',   'Men''s sportswear and athletic clothing', NULL);

SET @women_cat_id = 1;
SET @men_cat_id   = 2;

-- -----------------------------------------------------
-- WOMEN'S SUBCATEGORIES (3-7)
-- -----------------------------------------------------

INSERT INTO category (category_id, name, description, parent_category_id) VALUES
(3, 'Hoodies',  'Women''s hoodies and sweatshirts', @women_cat_id),
(4, 'Tops',     'Women''s tops, jerseys and shirts', @women_cat_id),
(5, 'Bottoms',  'Women''s bottoms, leggings and shorts', @women_cat_id),
(6, 'Footwear', 'Women''s athletic footwear', @women_cat_id),
(7, 'Headwear', 'Women''s caps, helmets and accessories', @women_cat_id);

SET
@women_hoodies_cat_id  = 3,
@women_tops_cat_id     = 4,
@women_bottoms_cat_id  = 5,
@women_footwear_cat_id = 6,
@women_headwear_cat_id = 7;

-- -----------------------------------------------------
-- MEN'S SUBCATEGORIES (8-12)
-- -----------------------------------------------------

INSERT INTO category (category_id, name, description, parent_category_id) VALUES
(8,  'Hoodies',  'Men''s hoodies and sweatshirts', @men_cat_id),
(9,  'Tops',     'Men''s tops, jerseys and shirts', @men_cat_id),
(10, 'Bottoms',  'Men''s bottoms, joggers and shorts', @men_cat_id),
(11, 'Footwear', 'Men''s athletic footwear', @men_cat_id),
(12, 'Headwear', 'Men''s caps, helmets and accessories', @men_cat_id);

SET
@men_hoodies_cat_id  = 8,
@men_tops_cat_id     = 9,
@men_bottoms_cat_id  = 10,
@men_footwear_cat_id = 11,
@men_headwear_cat_id = 12;

-- -----------------------------------------------------
-- Women's Hoodies (1–5)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(1, 'Black Athletiq Hoodie', 'Soft cotton hoodie designed for comfort during warm-ups, cool-downs, and everyday wear.', @women_hoodies_cat_id, 30.00),
(2, 'Green & Black Athletiq Hoodie', 'Two-tone hoodie with a relaxed fit, suitable for training sessions or casual layering.', @women_hoodies_cat_id, 35.00),
(3, 'White Athletiq Hoodie', 'Lightweight hoodie designed for comfort and easy everyday styling.', @women_hoodies_cat_id, 30.00),
(4, 'Green Athletiq Hoodie', 'Breathable hoodie built for comfortable movement and active lifestyles.', @women_hoodies_cat_id, 30.00),
(5, 'Grey Athletiq Hoodie', 'Classic hoodie with a relaxed fit, suitable for both training and casual wear.', @women_hoodies_cat_id, 30.00);

-- -----------------------------------------------------
-- Women's Tops (6–10)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(6, 'Athletiq Polo Tee', 'Breathable polo tee designed for training, active days, and casual sport wear.', @women_tops_cat_id, 39.99),
(7, 'Athletiq Football Jersey', 'Lightweight football jersey built for comfort and freedom of movement during play.', @women_tops_cat_id, 45.00),
(8, 'Athletiq Compression Top', 'Compression fit top designed to support movement during high-intensity workouts.', @women_tops_cat_id, 40.00),
(9, 'Athletiq Cami-Tanktop', 'Lightweight cami tank built for comfort and unrestricted movement during training.', @women_tops_cat_id, 25.00),
(10, 'Athletiq Basketball Jersey', 'Breathable basketball jersey designed for smooth movement and on-court comfort.', @women_tops_cat_id, 45.00);

-- -----------------------------------------------------
-- Women's Bottoms (11–15)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(11, 'Athletiq Tennis Skort', 'Flexible tennis skort designed for comfort, coverage, and ease of movement.', @women_bottoms_cat_id, 32.00),
(12, 'Athletiq Leggings', 'Stretch-fit leggings built for support and comfort across all training sessions.', @women_bottoms_cat_id, 35.00),
(13, 'Athletiq Swimming Shorts', 'Quick-dry swimming shorts designed for comfort in and around the water.', @women_bottoms_cat_id, 25.00),
(14, 'Athletiq Baggy Joggers', 'Relaxed-fit joggers suitable for training, recovery, and everyday wear.', @women_bottoms_cat_id, 49.99),
(15, 'Athletiq Cycling Shorts', 'Comfortable cycling shorts designed to support movement on longer rides.', @women_bottoms_cat_id, 30.00);

-- -----------------------------------------------------
-- Women's Footwear (16–20)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(16, 'Women''s Running Spikes', 'Lightweight running spikes designed for speed, grip, and track performance.', @women_footwear_cat_id, 85.99),
(17, 'Women''s Flip Flops', 'Easy slip-on flip flops ideal for poolside use and post-workout recovery.', @women_footwear_cat_id, 20.00),
(18, 'Women''s Running Shoes', 'Cushioned running shoes built for comfort and support over longer distances.', @women_footwear_cat_id, 80.00),
(19, 'Women''s Basketball Shoes', 'Basketball shoes designed for stability, grip, and quick movement on court.', @women_footwear_cat_id, 90.00),
(20, 'Women''s Football Boots', 'Studded football boots designed for traction and control on the pitch.', @women_footwear_cat_id, 85.99);

-- -----------------------------------------------------
-- Women's Headwear (21–25)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(21, 'Athletiq Visor', 'Open-top visor designed to provide shade without trapping heat.', @women_headwear_cat_id, 25.00),
(22, 'Athletiq Sweatband', 'Moisture-absorbing sweatband designed to keep sweat away during training.', @women_headwear_cat_id, 15.99),
(23, 'Athletiq Rugby Helmet', 'Protective rugby helmet designed for comfort, coverage, and on-pitch safety.', @women_headwear_cat_id, 75.00),
(24, 'Athletiq Baseball Cap', 'Classic baseball cap with a structured brim for sport or casual wear.', @women_headwear_cat_id, 35.00),
(25, 'Athletiq Swimcap', 'Swim cap designed to reduce drag and improve comfort in the water.', @women_headwear_cat_id, 10.99);

-- =====================================================
-- WOMEN'S PRODUCT VARIANTS
-- =====================================================

-- Women's Hoodie 1: Black (variants 101–105)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(101, 1, 'XS', 'Black', 'W-HOO-BLK-XS'),
(102, 1, 'S', 'Black', 'W-HOO-BLK-S'),
(103, 1, 'M', 'Black', 'W-HOO-BLK-M'),
(104, 1, 'L', 'Black', 'W-HOO-BLK-L'),
(105, 1, 'XL', 'Black', 'W-HOO-BLK-XL');

-- Women's Hoodie 2: Green & Black (variants 201–205)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(201, 2, 'XS', 'Green/Black', 'W-HOO-GRB-XS'),
(202, 2, 'S', 'Green/Black', 'W-HOO-GRB-S'),
(203, 2, 'M', 'Green/Black', 'W-HOO-GRB-M'),
(204, 2, 'L', 'Green/Black', 'W-HOO-GRB-L'),
(205, 2, 'XL', 'Green/Black', 'W-HOO-GRB-XL');

-- Women's Hoodie 3: White (variants 301–305)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(301, 3, 'XS', 'White', 'W-HOO-WHT-XS'),
(302, 3, 'S', 'White', 'W-HOO-WHT-S'),
(303, 3, 'M', 'White', 'W-HOO-WHT-M'),
(304, 3, 'L', 'White', 'W-HOO-WHT-L'),
(305, 3, 'XL', 'White', 'W-HOO-WHT-XL');

-- Women's Hoodie 4: Green (variants 401–405)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(401, 4, 'XS', 'Green', 'W-HOO-GRN-XS'),
(402, 4, 'S', 'Green', 'W-HOO-GRN-S'),
(403, 4, 'M', 'Green', 'W-HOO-GRN-M'),
(404, 4, 'L', 'Green', 'W-HOO-GRN-L'),
(405, 4, 'XL', 'Green', 'W-HOO-GRN-XL');

-- Women's Hoodie 5: Grey (variants 501–505)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(501, 5, 'XS', 'Grey', 'W-HOO-GRY-XS'),
(502, 5, 'S', 'Grey', 'W-HOO-GRY-S'),
(503, 5, 'M', 'Grey', 'W-HOO-GRY-M'),
(504, 5, 'L', 'Grey', 'W-HOO-GRY-L'),
(505, 5, 'XL', 'Grey', 'W-HOO-GRY-XL');

-- Women's Top 6: Polo Tee (variants 601–605)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(601, 6, 'XS', NULL, 'W-TOP-POL-XS'),
(602, 6, 'S', NULL, 'W-TOP-POL-S'),
(603, 6, 'M', NULL, 'W-TOP-POL-M'),
(604, 6, 'L', NULL, 'W-TOP-POL-L'),
(605, 6, 'XL', NULL, 'W-TOP-POL-XL');

-- Women's Top 7: Football Jersey (variants 701–705)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(701, 7, 'XS', NULL, 'W-TOP-FBJ-XS'),
(702, 7, 'S', NULL, 'W-TOP-FBJ-S'),
(703, 7, 'M', NULL, 'W-TOP-FBJ-M'),
(704, 7, 'L', NULL, 'W-TOP-FBJ-L'),
(705, 7, 'XL', NULL, 'W-TOP-FBJ-XL');

-- Women's Top 8: Compression Top (variants 801–805)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(801, 8, 'XS', NULL, 'W-TOP-CMP-XS'),
(802, 8, 'S', NULL, 'W-TOP-CMP-S'),
(803, 8, 'M', NULL, 'W-TOP-CMP-M'),
(804, 8, 'L', NULL, 'W-TOP-CMP-L'),
(805, 8, 'XL', NULL, 'W-TOP-CMP-XL');

-- Women's Top 9: Cami-Tanktop (variants 901–905)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(901, 9, 'XS', NULL, 'W-TOP-CAM-XS'),
(902, 9, 'S', NULL, 'W-TOP-CAM-S'),
(903, 9, 'M', NULL, 'W-TOP-CAM-M'),
(904, 9, 'L', NULL, 'W-TOP-CAM-L'),
(905, 9, 'XL', NULL, 'W-TOP-CAM-XL');

-- Women's Top 10: Basketball Jersey (variants 1001–1005)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1001, 10, 'XS', NULL, 'W-TOP-BBJ-XS'),
(1002, 10, 'S', NULL, 'W-TOP-BBJ-S'),
(1003, 10, 'M', NULL, 'W-TOP-BBJ-M'),
(1004, 10, 'L', NULL, 'W-TOP-BBJ-L'),
(1005, 10, 'XL', NULL, 'W-TOP-BBJ-XL');

-- Women's Bottom 11: Tennis Skort (variants 1101–1105)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1101, 11, 'XS', NULL, 'W-BOT-TSK-XS'),
(1102, 11, 'S', NULL, 'W-BOT-TSK-S'),
(1103, 11, 'M', NULL, 'W-BOT-TSK-M'),
(1104, 11, 'L', NULL, 'W-BOT-TSK-L'),
(1105, 11, 'XL', NULL, 'W-BOT-TSK-XL');

-- Women's Bottom 12: Leggings (variants 1201–1205)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1201, 12, 'XS', NULL, 'W-BOT-LEG-XS'),
(1202, 12, 'S', NULL, 'W-BOT-LEG-S'),
(1203, 12, 'M', NULL, 'W-BOT-LEG-M'),
(1204, 12, 'L', NULL, 'W-BOT-LEG-L'),
(1205, 12, 'XL', NULL, 'W-BOT-LEG-XL');

-- Women's Bottom 13: Swimming Shorts (variants 1301–1305)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1301, 13, 'XS', NULL, 'W-BOT-SWM-XS'),
(1302, 13, 'S', NULL, 'W-BOT-SWM-S'),
(1303, 13, 'M', NULL, 'W-BOT-SWM-M'),
(1304, 13, 'L', NULL, 'W-BOT-SWM-L'),
(1305, 13, 'XL', NULL, 'W-BOT-SWM-XL');

-- Women's Bottom 14: Baggy Joggers (variants 1401–1405)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1401, 14, 'XS', NULL, 'W-BOT-JOG-XS'),
(1402, 14, 'S', NULL, 'W-BOT-JOG-S'),
(1403, 14, 'M', NULL, 'W-BOT-JOG-M'),
(1404, 14, 'L', NULL, 'W-BOT-JOG-L'),
(1405, 14, 'XL', NULL, 'W-BOT-JOG-XL');

-- Women's Bottom 15: Cycling Shorts (variants 1501–1505)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1501, 15, 'XS', NULL, 'W-BOT-CYC-XS'),
(1502, 15, 'S', NULL, 'W-BOT-CYC-S'),
(1503, 15, 'M', NULL, 'W-BOT-CYC-M'),
(1504, 15, 'L', NULL, 'W-BOT-CYC-L'),
(1505, 15, 'XL', NULL, 'W-BOT-CYC-XL');

-- Women's Footwear 16: Running Spikes (variants 1601–1607, UK 3–9)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1601, 16, '3', NULL, 'W-FT-RSP-3'),
(1602, 16, '4', NULL, 'W-FT-RSP-4'),
(1603, 16, '5', NULL, 'W-FT-RSP-5'),
(1604, 16, '6', NULL, 'W-FT-RSP-6'),
(1605, 16, '7', NULL, 'W-FT-RSP-7'),
(1606, 16, '8', NULL, 'W-FT-RSP-8'),
(1607, 16, '9', NULL, 'W-FT-RSP-9');

-- Women's Footwear 17: Flip Flops (variants 1701–1707, UK 3–9)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1701, 17, '3', NULL, 'W-FT-FLP-3'),
(1702, 17, '4', NULL, 'W-FT-FLP-4'),
(1703, 17, '5', NULL, 'W-FT-FLP-5'),
(1704, 17, '6', NULL, 'W-FT-FLP-6'),
(1705, 17, '7', NULL, 'W-FT-FLP-7'),
(1706, 17, '8', NULL, 'W-FT-FLP-8'),
(1707, 17, '9', NULL, 'W-FT-FLP-9');

-- Women's Footwear 18: Running Shoes (variants 1801–1807, UK 3–9)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1801, 18, '3', NULL, 'W-FT-RSH-3'),
(1802, 18, '4', NULL, 'W-FT-RSH-4'),
(1803, 18, '5', NULL, 'W-FT-RSH-5'),
(1804, 18, '6', NULL, 'W-FT-RSH-6'),
(1805, 18, '7', NULL, 'W-FT-RSH-7'),
(1806, 18, '8', NULL, 'W-FT-RSH-8'),
(1807, 18, '9', NULL, 'W-FT-RSH-9');

-- Women's Footwear 19: Basketball Shoes (variants 1901–1907, UK 3–9)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(1901, 19, '3', NULL, 'W-FT-BSH-3'),
(1902, 19, '4', NULL, 'W-FT-BSH-4'),
(1903, 19, '5', NULL, 'W-FT-BSH-5'),
(1904, 19, '6', NULL, 'W-FT-BSH-6'),
(1905, 19, '7', NULL, 'W-FT-BSH-7'),
(1906, 19, '8', NULL, 'W-FT-BSH-8'),
(1907, 19, '9', NULL, 'W-FT-BSH-9');

-- Women's Footwear 20: Football Boots (variants 2001–2007, UK 3–9)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2001, 20, '3', NULL, 'W-FT-FBT-3'),
(2002, 20, '4', NULL, 'W-FT-FBT-4'),
(2003, 20, '5', NULL, 'W-FT-FBT-5'),
(2004, 20, '6', NULL, 'W-FT-FBT-6'),
(2005, 20, '7', NULL, 'W-FT-FBT-7'),
(2006, 20, '8', NULL, 'W-FT-FBT-8'),
(2007, 20, '9', NULL, 'W-FT-FBT-9');

-- Women's Headwear 21: Visor (variants 2101–2105)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2101, 21, 'XS', NULL, 'W-HD-VIS-XS'),
(2102, 21, 'S', NULL, 'W-HD-VIS-S'),
(2103, 21, 'M', NULL, 'W-HD-VIS-M'),
(2104, 21, 'L', NULL, 'W-HD-VIS-L'),
(2105, 21, 'XL', NULL, 'W-HD-VIS-XL');

-- Women's Headwear 22: Sweatband (variants 2201–2205)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2201, 22, 'XS', NULL, 'W-HD-SWB-XS'),
(2202, 22, 'S', NULL, 'W-HD-SWB-S'),
(2203, 22, 'M', NULL, 'W-HD-SWB-M'),
(2204, 22, 'L', NULL, 'W-HD-SWB-L'),
(2205, 22, 'XL', NULL, 'W-HD-SWB-XL');

-- Women's Headwear 23: Rugby Helmet (variants 2301–2305)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2301, 23, 'XS', NULL, 'W-HD-RGH-XS'),
(2302, 23, 'S', NULL, 'W-HD-RGH-S'),
(2303, 23, 'M', NULL, 'W-HD-RGH-M'),
(2304, 23, 'L', NULL, 'W-HD-RGH-L'),
(2305, 23, 'XL', NULL, 'W-HD-RGH-XL');

-- Women's Headwear 24: Baseball Cap (variants 2401–2405)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2401, 24, 'XS', NULL, 'W-HD-BBC-XS'),
(2402, 24, 'S', NULL, 'W-HD-BBC-S'),
(2403, 24, 'M', NULL, 'W-HD-BBC-M'),
(2404, 24, 'L', NULL, 'W-HD-BBC-L'),
(2405, 24, 'XL', NULL, 'W-HD-BBC-XL');

-- Women's Headwear 25: Swimcap (variants 2501–2505)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2501, 25, 'XS', NULL, 'W-HD-SWC-XS'),
(2502, 25, 'S', NULL, 'W-HD-SWC-S'),
(2503, 25, 'M', NULL, 'W-HD-SWC-M'),
(2504, 25, 'L', NULL, 'W-HD-SWC-L'),
(2505, 25, 'XL', NULL, 'W-HD-SWC-XL');

-- =====================================================
-- PRODUCT IMAGES
-- =====================================================

-- Women's Hoodies
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(1, '/src/view/images/productImages/women_black_hoodie.png', 1),
(2, '/src/view/images/productImages/women_green_black_hoodie.png', 1),
(3, '/src/view/images/productImages/women_white_hoodie.png', 1),
(4, '/src/view/images/productImages/women_green_hoodie.png', 1),
(5, '/src/view/images/productImages/women_grey_hoodie.png', 1);

-- Women's Tops
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(6, '/src/view/images/productImages/women_polo_tee.png', 1),
(7, '/src/view/images/productImages/women_football_jersey.png', 1),
(8, '/src/view/images/productImages/women_compression_shirt.png', 1),
(9, '/src/view/images/productImages/women_cami_tank_top.png', 1),
(10, '/src/view/images/productImages/women_basketball_jersey.png', 1);

-- Women's Bottoms
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(11, '/src/view/images/productImages/women_tennis_skort.png', 1),
(12, '/src/view/images/productImages/women_leggings.png', 1),
(13, '/src/view/images/productImages/women_swimming_shorts.png', 1),
(14, '/src/view/images/productImages/women_joggers.png', 1),
(15, '/src/view/images/productImages/women_cycling_shorts.png', 1);

-- Women's Footwear
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(16, '/src/view/images/productImages/women_running_spikes.png', 1),
(17, '/src/view/images/productImages/women_flip_flops.png', 1),
(18, '/src/view/images/productImages/women_running_shoes.png', 1),
(19, '/src/view/images/productImages/women_basketball_shoes.png', 1),
(20, '/src/view/images/productImages/women_football_boots.png', 1);

-- Women's Headwear
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(21, '/src/view/images/productImages/women_visor_cap.png', 1),
(22, '/src/view/images/productImages/women_sweatband.png', 1),
(23, '/src/view/images/productImages/women_rugby_helmet.png', 1),
(24, '/src/view/images/productImages/women_baseball_cap.png', 1),
(25, '/src/view/images/productImages/women_swimcap.png', 1);

-- =====================================================
-- INITIAL INVENTORY
-- =====================================================

-- Women's Hoodies
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(101, 50, 10),(102, 50, 10),(103, 50, 10),(104, 50, 10),(105, 50, 10),
(201, 50, 10),(202, 50, 10),(203, 50, 10),(204, 50, 10),(205, 50, 10),
(301, 50, 10),(302, 50, 10),(303, 50, 10),(304, 50, 10),(305, 50, 10),
(401, 50, 10),(402, 50, 10),(403, 50, 10),(404, 50, 10),(405, 50, 10),
(501, 50, 10),(502, 50, 10),(503, 50, 10),(504, 50, 10),(505, 50, 10);

-- Women's Tops
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(601, 50, 10),(602, 50, 10),(603, 50, 10),(604, 50, 10),(605, 50, 10),
(701, 50, 10),(702, 50, 10),(703, 50, 10),(704, 50, 10),(705, 50, 10),
(801, 50, 10),(802, 50, 10),(803, 50, 10),(804, 50, 10),(805, 50, 10),
(901, 50, 10),(902, 50, 10),(903, 50, 10),(904, 50, 10),(905, 50, 10),
(1001, 50, 10),(1002, 50, 10),(1003, 50, 10),(1004, 50, 10),(1005, 50, 10);

-- Women's Bottoms
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(1101, 50, 10),(1102, 50, 10),(1103, 50, 10),(1104, 50, 10),(1105, 50, 10),
(1201, 50, 10),(1202, 50, 10),(1203, 50, 10),(1204, 50, 10),(1205, 50, 10),
(1301, 50, 10),(1302, 50, 10),(1303, 50, 10),(1304, 50, 10),(1305, 50, 10),
(1401, 50, 10),(1402, 50, 10),(1403, 50, 10),(1404, 50, 10),(1405, 50, 10),
(1501, 50, 10),(1502, 50, 10),(1503, 50, 10),(1504, 50, 10),(1505, 50, 10);

-- Women's Footwear
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(1601, 35, 10),(1602, 35, 10),(1603, 50, 10),(1604, 50, 10),(1605, 50, 10),(1606, 25, 10),(1607, 25, 10),
(1701, 35, 10),(1702, 35, 10),(1703, 50, 10),(1704, 50, 10),(1705, 50, 10),(1706, 25, 10),(1707, 25, 10),
(1801, 35, 10),(1802, 35, 10),(1803, 50, 10),(1804, 50, 10),(1805, 50, 10),(1806, 25, 10),(1807, 25, 10),
(1901, 35, 10),(1902, 35, 10),(1903, 50, 10),(1904, 50, 10),(1905, 50, 10),(1906, 25, 10),(1907, 25, 10),
(2001, 35, 10),(2002, 35, 10),(2003, 50, 10),(2004, 50, 10),(2005, 50, 10),(2006, 25, 10),(2007, 25, 10);

-- Women's Headwear
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(2101, 50, 10),(2102, 50, 10),(2103, 50, 10),(2104, 50, 10),(2105, 50, 10),
(2201, 50, 10),(2202, 50, 10),(2203, 50, 10),(2204, 50, 10),(2205, 50, 10),
(2301, 50, 10),(2302, 50, 10),(2303, 50, 10),(2304, 50, 10),(2305, 50, 10),
(2401, 50, 10),(2402, 50, 10),(2403, 50, 10),(2404, 50, 10),(2405, 50, 10),
(2501, 50, 10),(2502, 50, 10),(2503, 50, 10),(2504, 50, 10),(2505, 50, 10);

-- -----------------------------------------------------
-- Men's Hoodies (26–30)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(26, 'Green Athletiq Hoodie', 'Lightweight cotton hoodie built for warm-ups, cool-downs, and everyday comfort.', @men_hoodies_cat_id, 30.00),
(27, 'Green & Black Athletiq Hoodie', 'Two-tone hoodie with a relaxed fit, suitable for training or casual wear.', @men_hoodies_cat_id, 35.00),
(28, 'Green & Black Zipup Athletiq Turtleneck', 'Zip-up turtleneck hoodie designed to provide warmth during colder training sessions.', @men_hoodies_cat_id, 30.00),
(29, 'Green Athletiq Turtleneck', 'Turtleneck hoodie built for comfort and added coverage in cooler conditions.', @men_hoodies_cat_id, 30.00),
(30, 'Green Zip up Athletiq Hoodie', 'Zip-up hoodie designed for easy layering before and after training sessions.', @men_hoodies_cat_id, 30.00);

-- -----------------------------------------------------
-- Men's Tops (31–35)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(31, 'Athletiq Polo Tee', 'Breathable polo tee suitable for training, active days, and casual sport wear.', @men_tops_cat_id, 40.00),
(32, 'Athletiq Football Jersey', 'Lightweight football jersey designed for comfort and mobility on the pitch.', @men_tops_cat_id, 45.00),
(33, 'Athletiq Compression Top', 'Compression fit top built to support muscles during high-intensity workouts.', @men_tops_cat_id, 40.00),
(34, 'Athletiq Gym Tanktop', 'Lightweight tank top designed for unrestricted movement during gym sessions.', @men_tops_cat_id, 25.00),
(35, 'Athletiq Basketball Jersey', 'Moisture-wicking basketball jersey designed for comfort and on-court performance.', @men_tops_cat_id, 45.00);

-- -----------------------------------------------------
-- Men's Bottoms (36–40)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(36, 'Athletiq Tennis Shorts', 'Lightweight tennis shorts designed for quick movement and on-court comfort.', @men_bottoms_cat_id, 32.00),
(37, 'Athletiq Rugby Shorts', 'Durable rugby shorts built to handle the demands of contact sport.', @men_bottoms_cat_id, 35.00),
(38, 'Athletiq Swimming Shorts', 'Quick-dry swimming shorts designed for comfort in and around the water.', @men_bottoms_cat_id, 25.00),
(39, 'Athletiq Joggers', 'Tapered joggers designed for training, recovery, and everyday wear.', @men_bottoms_cat_id, 50.00),
(40, 'Athletiq Boxing Shorts', 'Boxing shorts designed for full freedom of movement during training sessions.', @men_bottoms_cat_id, 30.00);

-- -----------------------------------------------------
-- Men's Footwear (41–45)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(41, 'Mens Mountaineering Boots', 'Sturdy boots designed with grip and support for rugged outdoor conditions.', @men_footwear_cat_id, 85.00),
(42, 'Mens Flip Flops', 'Lightweight flip flops ideal for poolside use and post-training recovery.', @men_footwear_cat_id, 20.00),
(43, 'Mens Running Shoes', 'Cushioned running shoes built for comfort and long-distance support.', @men_footwear_cat_id, 80.00),
(44, 'Mens Trainers', 'Versatile trainers suitable for gym sessions and everyday wear.', @men_footwear_cat_id, 90.00),
(45, 'Mens Football Boots', 'Studded football boots designed for traction and control on grass pitches.', @men_footwear_cat_id, 85.00);

-- -----------------------------------------------------
-- Men's Headwear (46–50)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(46, 'Athletiq Visor', 'Open-top visor designed to provide shade while allowing heat to escape.', @men_headwear_cat_id, 25.00),
(47, 'Athletiq Sweatband', 'Moisture-absorbing sweatband designed to keep sweat away during training.', @men_headwear_cat_id, 15.00),
(48, 'Athletiq Rugby Helmet', 'Padded rugby helmet designed for protection without restricting movement.', @men_headwear_cat_id, 75.00),
(49, 'Athletiq Baseball Cap', 'Adjustable baseball cap with a structured brim for sport or casual wear.', @men_headwear_cat_id, 35.00),
(50, 'Athletiq Swimcap', 'Swim cap designed to reduce drag and improve comfort in the water.', @men_headwear_cat_id, 10.00);
-- =====================================================
-- MEN'S PRODUCT VARIANTS
-- =====================================================

-- Men's Hoodie 26: Green (variants 2601–2605)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2601, 26, 'XS', 'Green', 'M-HOO-GRN-XS'),
(2602, 26, 'S', 'Green', 'M-HOO-GRN-S'),
(2603, 26, 'M', 'Green', 'M-HOO-GRN-M'),
(2604, 26, 'L', 'Green', 'M-HOO-GRN-L'),
(2605, 26, 'XL', 'Green', 'M-HOO-GRN-XL');

-- Men's Hoodie 27: Green & Black (variants 2701–2705)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2701, 27, 'XS', 'Green/Black', 'M-HOO-GRB-XS'),
(2702, 27, 'S', 'Green/Black', 'M-HOO-GRB-S'),
(2703, 27, 'M', 'Green/Black', 'M-HOO-GRB-M'),
(2704, 27, 'L', 'Green/Black', 'M-HOO-GRB-L'),
(2705, 27, 'XL', 'Green/Black', 'M-HOO-GRB-XL');

-- Men's Hoodie 28: Green & Black Zipup Turtleneck (variants 2801–2805)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2801, 28, 'XS', 'Green/Black', 'M-HOO-ZTL-XS'),
(2802, 28, 'S', 'Green/Black', 'M-HOO-ZTL-S'),
(2803, 28, 'M', 'Green/Black', 'M-HOO-ZTL-M'),
(2804, 28, 'L', 'Green/Black', 'M-HOO-ZTL-L'),
(2805, 28, 'XL', 'Green/Black', 'M-HOO-ZTL-XL');

-- Men's Hoodie 29: Green Turtleneck (variants 2901–2905)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(2901, 29, 'XS', 'Green', 'M-HOO-TUR-XS'),
(2902, 29, 'S', 'Green', 'M-HOO-TUR-S'),
(2903, 29, 'M', 'Green', 'M-HOO-TUR-M'),
(2904, 29, 'L', 'Green', 'M-HOO-TUR-L'),
(2905, 29, 'XL', 'Green', 'M-HOO-TUR-XL');

-- Men's Hoodie 30: Green Zip up Hoodie (variants 3001–3005)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3001, 30, 'XS', 'Green', 'M-HOO-ZIP-XS'),
(3002, 30, 'S', 'Green', 'M-HOO-ZIP-S'),
(3003, 30, 'M', 'Green', 'M-HOO-ZIP-M'),
(3004, 30, 'L', 'Green', 'M-HOO-ZIP-L'),
(3005, 30, 'XL', 'Green', 'M-HOO-ZIP-XL');

-- Men's Top 31: Polo Tee (variants 3101–3105)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3101, 31, 'XS', NULL, 'M-TOP-POL-XS'),
(3102, 31, 'S', NULL, 'M-TOP-POL-S'),
(3103, 31, 'M', NULL, 'M-TOP-POL-M'),
(3104, 31, 'L', NULL, 'M-TOP-POL-L'),
(3105, 31, 'XL', NULL, 'M-TOP-POL-XL');

-- Men's Top 32: Football Jersey (variants 3201–3205)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3201, 32, 'XS', NULL, 'M-TOP-FBJ-XS'),
(3202, 32, 'S', NULL, 'M-TOP-FBJ-S'),
(3203, 32, 'M', NULL, 'M-TOP-FBJ-M'),
(3204, 32, 'L', NULL, 'M-TOP-FBJ-L'),
(3205, 32, 'XL', NULL, 'M-TOP-FBJ-XL');

-- Men's Top 33: Compression Top (variants 3301–3305)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3301, 33, 'XS', NULL, 'M-TOP-CMP-XS'),
(3302, 33, 'S', NULL, 'M-TOP-CMP-S'),
(3303, 33, 'M', NULL, 'M-TOP-CMP-M'),
(3304, 33, 'L', NULL, 'M-TOP-CMP-L'),
(3305, 33, 'XL', NULL, 'M-TOP-CMP-XL');

-- Men's Top 34: Gym Tanktop (variants 3401–3405)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3401, 34, 'XS', NULL, 'M-TOP-TNK-XS'),
(3402, 34, 'S', NULL, 'M-TOP-TNK-S'),
(3403, 34, 'M', NULL, 'M-TOP-TNK-M'),
(3404, 34, 'L', NULL, 'M-TOP-TNK-L'),
(3405, 34, 'XL', NULL, 'M-TOP-TNK-XL');

-- Men's Top 35: Basketball Jersey (variants 3501–3505)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3501, 35, 'XS', NULL, 'M-TOP-BBJ-XS'),
(3502, 35, 'S', NULL, 'M-TOP-BBJ-S'),
(3503, 35, 'M', NULL, 'M-TOP-BBJ-M'),
(3504, 35, 'L', NULL, 'M-TOP-BBJ-L'),
(3505, 35, 'XL', NULL, 'M-TOP-BBJ-XL');

-- Men's Bottom 36: Tennis Shorts (variants 3601–3605)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3601, 36, 'XS', NULL, 'M-BOT-TNS-XS'),
(3602, 36, 'S', NULL, 'M-BOT-TNS-S'),
(3603, 36, 'M', NULL, 'M-BOT-TNS-M'),
(3604, 36, 'L', NULL, 'M-BOT-TNS-L'),
(3605, 36, 'XL', NULL, 'M-BOT-TNS-XL');

-- Men's Bottom 37: Rugby Shorts (variants 3701–3705)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3701, 37, 'XS', NULL, 'M-BOT-RUG-XS'),
(3702, 37, 'S', NULL, 'M-BOT-RUG-S'),
(3703, 37, 'M', NULL, 'M-BOT-RUG-M'),
(3704, 37, 'L', NULL, 'M-BOT-RUG-L'),
(3705, 37, 'XL', NULL, 'M-BOT-RUG-XL');

-- Men's Bottom 38: Swimming Shorts (variants 3801–3805)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3801, 38, 'XS', NULL, 'M-BOT-SWM-XS'),
(3802, 38, 'S', NULL, 'M-BOT-SWM-S'),
(3803, 38, 'M', NULL, 'M-BOT-SWM-M'),
(3804, 38, 'L', NULL, 'M-BOT-SWM-L'),
(3805, 38, 'XL', NULL, 'M-BOT-SWM-XL');

-- Men's Bottom 39: Joggers (variants 3901–3905)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(3901, 39, 'XS', NULL, 'M-BOT-JOG-XS'),
(3902, 39, 'S', NULL, 'M-BOT-JOG-S'),
(3903, 39, 'M', NULL, 'M-BOT-JOG-M'),
(3904, 39, 'L', NULL, 'M-BOT-JOG-L'),
(3905, 39, 'XL', NULL, 'M-BOT-JOG-XL');

-- Men's Bottom 40: Boxing Shorts (variants 4001–4005)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4001, 40, 'XS', NULL, 'M-BOT-BOX-XS'),
(4002, 40, 'S', NULL, 'M-BOT-BOX-S'),
(4003, 40, 'M', NULL, 'M-BOT-BOX-M'),
(4004, 40, 'L', NULL, 'M-BOT-BOX-L'),
(4005, 40, 'XL', NULL, 'M-BOT-BOX-XL');

-- Men's Footwear 41: Mountaineering Boots (variants 4101–4108, UK 5–12)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4101, 41, '5', NULL, 'M-FT-MTB-5'),
(4102, 41, '6', NULL, 'M-FT-MTB-6'),
(4103, 41, '7', NULL, 'M-FT-MTB-7'),
(4104, 41, '8', NULL, 'M-FT-MTB-8'),
(4105, 41, '9', NULL, 'M-FT-MTB-9'),
(4106, 41, '10', NULL, 'M-FT-MTB-10'),
(4107, 41, '11', NULL, 'M-FT-MTB-11'),
(4108, 41, '12', NULL, 'M-FT-MTB-12');

-- Men's Footwear 42: Flip Flops (variants 4201–4208, UK 5–12)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4201, 42, '5', NULL, 'M-FT-FLP-5'),
(4202, 42, '6', NULL, 'M-FT-FLP-6'),
(4203, 42, '7', NULL, 'M-FT-FLP-7'),
(4204, 42, '8', NULL, 'M-FT-FLP-8'),
(4205, 42, '9', NULL, 'M-FT-FLP-9'),
(4206, 42, '10', NULL, 'M-FT-FLP-10'),
(4207, 42, '11', NULL, 'M-FT-FLP-11'),
(4208, 42, '12', NULL, 'M-FT-FLP-12');

-- Men's Footwear 43: Running Shoes (variants 4301–4308, UK 5–12)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4301, 43, '5', NULL, 'M-FT-RSH-5'),
(4302, 43, '6', NULL, 'M-FT-RSH-6'),
(4303, 43, '7', NULL, 'M-FT-RSH-7'),
(4304, 43, '8', NULL, 'M-FT-RSH-8'),
(4305, 43, '9', NULL, 'M-FT-RSH-9'),
(4306, 43, '10', NULL, 'M-FT-RSH-10'),
(4307, 43, '11', NULL, 'M-FT-RSH-11'),
(4308, 43, '12', NULL, 'M-FT-RSH-12');

-- Men's Footwear 44: Trainers (variants 4401–4408, UK 5–12)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4401, 44, '5', NULL, 'M-FT-TRN-5'),
(4402, 44, '6', NULL, 'M-FT-TRN-6'),
(4403, 44, '7', NULL, 'M-FT-TRN-7'),
(4404, 44, '8', NULL, 'M-FT-TRN-8'),
(4405, 44, '9', NULL, 'M-FT-TRN-9'),
(4406, 44, '10', NULL, 'M-FT-TRN-10'),
(4407, 44, '11', NULL, 'M-FT-TRN-11'),
(4408, 44, '12', NULL, 'M-FT-TRN-12');

-- Men's Footwear 45: Football Boots (variants 4501–4508, UK 5–12)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4501, 45, '5', NULL, 'M-FT-FBT-5'),
(4502, 45, '6', NULL, 'M-FT-FBT-6'),
(4503, 45, '7', NULL, 'M-FT-FBT-7'),
(4504, 45, '8', NULL, 'M-FT-FBT-8'),
(4505, 45, '9', NULL, 'M-FT-FBT-9'),
(4506, 45, '10', NULL, 'M-FT-FBT-10'),
(4507, 45, '11', NULL, 'M-FT-FBT-11'),
(4508, 45, '12', NULL, 'M-FT-FBT-12');

-- Men's Headwear 46: Visor (variants 4601–4605)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4601, 46, 'XS', NULL, 'M-HD-VIS-XS'),
(4602, 46, 'S', NULL, 'M-HD-VIS-S'),
(4603, 46, 'M', NULL, 'M-HD-VIS-M'),
(4604, 46, 'L', NULL, 'M-HD-VIS-L'),
(4605, 46, 'XL', NULL, 'M-HD-VIS-XL');

-- Men's Headwear 47: Sweatband (variants 4701–4705)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4701, 47, 'XS', NULL, 'M-HD-SWB-XS'),
(4702, 47, 'S', NULL, 'M-HD-SWB-S'),
(4703, 47, 'M', NULL, 'M-HD-SWB-M'),
(4704, 47, 'L', NULL, 'M-HD-SWB-L'),
(4705, 47, 'XL', NULL, 'M-HD-SWB-XL');

-- Men's Headwear 48: Rugby Helmet (variants 4801–4805)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4801, 48, 'XS', NULL, 'M-HD-RGH-XS'),
(4802, 48, 'S', NULL, 'M-HD-RGH-S'),
(4803, 48, 'M', NULL, 'M-HD-RGH-M'),
(4804, 48, 'L', NULL, 'M-HD-RGH-L'),
(4805, 48, 'XL', NULL, 'M-HD-RGH-XL');

-- Men's Headwear 49: Baseball Cap (variants 4901–4905)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(4901, 49, 'XS', NULL, 'M-HD-BBC-XS'),
(4902, 49, 'S', NULL, 'M-HD-BBC-S'),
(4903, 49, 'M', NULL, 'M-HD-BBC-M'),
(4904, 49, 'L', NULL, 'M-HD-BBC-L'),
(4905, 49, 'XL', NULL, 'M-HD-BBC-XL');

-- Men's Headwear 50: Swimcap (variants 5001–5005)
INSERT INTO product_variant (variant_id, product_id, size, colour, sku) VALUES
(5001, 50, 'XS', NULL, 'M-HD-SWC-XS'),
(5002, 50, 'S', NULL, 'M-HD-SWC-S'),
(5003, 50, 'M', NULL, 'M-HD-SWC-M'),
(5004, 50, 'L', NULL, 'M-HD-SWC-L'),
(5005, 50, 'XL', NULL, 'M-HD-SWC-XL');

-- =====================================================
-- PRODUCT IMAGES
-- =====================================================

-- Men's Hoodies
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(26, '/src/view/images/productImages/male_hoodie_green.png', 1),
(27, '/src/view/images/productImages/male_hoodie_black.png', 1),
(28, '/src/view/images/productImages/male_hoodie_turtleneck_zipup.png', 1),
(29, '/src/view/images/productImages/male_hoodie_turtleneck.png', 1),
(30, '/src/view/images/productImages/male_hoodie_zipup.png', 1);

-- Men's Tops
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(31, '/src/view/images/productImages/male_shirt_polo.png', 1),
(32, '/src/view/images/productImages/male_shirt_football.png', 1),
(33, '/src/view/images/productImages/male_shirt_compression.png', 1),
(34, '/src/view/images/productImages/male_shirt_tank.png', 1),
(35, '/src/view/images/productImages/male_shirt_basketball.png', 1);

-- Men's Bottoms
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(36, '/src/view/images/productImages/male_pants_tennis.png', 1),
(37, '/src/view/images/productImages/male_pants_rugby.png', 1),
(38, '/src/view/images/productImages/male_pants_swimming.png', 1),
(39, '/src/view/images/productImages/male_joggers.png', 1),
(40, '/src/view/images/productImages/male_pants_boxing.png', 1);

-- Men's Footwear
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(41, '/src/view/images/productImages/male_shoes_mountaineering.png', 1),
(42, '/src/view/images/productImages/male_shoes_flipflops.png', 1),
(43, '/src/view/images/productImages/male_shoes_running.png', 1),
(44, '/src/view/images/productImages/male_shoes_trainers.png', 1),
(45, '/src/view/images/productImages/male_shoes_studs.png', 1);

-- Men's Headwear
INSERT INTO product_image (product_id, image_url, is_main) VALUES
(46, '/src/view/images/productImages/male_hat_visor.png', 1),
(47, '/src/view/images/productImages/male_hat_sweatband.png', 1),
(48, '/src/view/images/productImages/male_hat_rugby.png', 1),
(49, '/src/view/images/productImages/male_hat_baseball.png', 1),
(50, '/src/view/images/productImages/male_hat_swimming.png', 1);

-- =====================================================
-- INITIAL INVENTORY
-- =====================================================

-- Men's Hoodies
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(2601, 50, 10),(2602, 50, 10),(2603, 50, 10),(2604, 50, 10),(2605, 50, 10),
(2701, 50, 10),(2702, 50, 10),(2703, 50, 10),(2704, 50, 10),(2705, 50, 10),
(2801, 50, 10),(2802, 50, 10),(2803, 50, 10),(2804, 50, 10),(2805, 50, 10),
(2901, 50, 10),(2902, 50, 10),(2903, 50, 10),(2904, 50, 10),(2905, 50, 10),
(3001, 50, 10),(3002, 50, 10),(3003, 50, 10),(3004, 50, 10),(3005, 50, 10);

-- Men's Tops
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(3101, 50, 10),(3102, 50, 10),(3103, 50, 10),(3104, 50, 10),(3105, 50, 10),
(3201, 50, 10),(3202, 50, 10),(3203, 50, 10),(3204, 50, 10),(3205, 50, 10),
(3301, 50, 10),(3302, 50, 10),(3303, 50, 10),(3304, 50, 10),(3305, 50, 10),
(3401, 50, 10),(3402, 50, 10),(3403, 50, 10),(3404, 50, 10),(3405, 50, 10),
(3501, 50, 10),(3502, 50, 10),(3503, 50, 10),(3504, 50, 10),(3505, 50, 10);

-- Men's Bottoms
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(3601, 50, 10),(3602, 50, 10),(3603, 50, 10),(3604, 50, 10),(3605, 50, 10),
(3701, 50, 10),(3702, 50, 10),(3703, 50, 10),(3704, 50, 10),(3705, 50, 10),
(3801, 50, 10),(3802, 50, 10),(3803, 50, 10),(3804, 50, 10),(3805, 50, 10),
(3901, 50, 10),(3902, 50, 10),(3903, 50, 10),(3904, 50, 10),(3905, 50, 10),
(4001, 50, 10),(4002, 50, 10),(4003, 50, 10),(4004, 50, 10),(4005, 50, 10);

-- Men's Footwear
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(4101, 35, 10),(4102, 35, 10),(4103, 50, 10),(4104, 50, 10),(4105, 50, 10),(4106, 25, 10),(4107, 25, 10),(4108, 20, 10),
(4201, 35, 10),(4202, 35, 10),(4203, 50, 10),(4204, 50, 10),(4205, 50, 10),(4206, 25, 10),(4207, 25, 10),(4208, 20, 10),
(4301, 35, 10),(4302, 35, 10),(4303, 50, 10),(4304, 50, 10),(4305, 50, 10),(4306, 25, 10),(4307, 25, 10),(4308, 20, 10),
(4401, 35, 10),(4402, 35, 10),(4403, 50, 10),(4404, 50, 10),(4405, 50, 10),(4406, 25, 10),(4407, 25, 10),(4408, 20, 10),
(4501, 35, 10),(4502, 35, 10),(4503, 50, 10),(4504, 50, 10),(4505, 50, 10),(4506, 25, 10),(4507, 25, 10),(4508, 20, 10);

-- Men's Headwear
INSERT INTO inventory (variant_id, current_stock, low_stock_threshold) VALUES
(4601, 50, 10),(4602, 50, 10),(4603, 50, 10),(4604, 50, 10),(4605, 50, 10),
(4701, 50, 10),(4702, 50, 10),(4703, 50, 10),(4704, 50, 10),(4705, 50, 10),
(4801, 50, 10),(4802, 50, 10),(4803, 50, 10),(4804, 50, 10),(4805, 50, 10),
(4901, 50, 10),(4902, 50, 10),(4903, 50, 10),(4904, 50, 10),(4905, 50, 10),
(5001, 50, 10),(5002, 50, 10),(5003, 50, 10),(5004, 50, 10),(5005, 50, 10);