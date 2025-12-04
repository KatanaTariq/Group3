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
(1, 'Black Athletiq Hoodie', 'Classic black hoodie with Athletiq branding', @women_hoodies_cat_id, 30.00),
(2, 'Green & Black Athletiq Hoodie', 'Two-tone green and black hoodie', @women_hoodies_cat_id, 35.00),
(3, 'White Athletiq Hoodie', 'Clean white hoodie with Athletiq branding', @women_hoodies_cat_id, 30.00),
(4, 'Green Athletiq Hoodie', 'Vibrant green hoodie with Athletiq branding', @women_hoodies_cat_id, 30.00),
(5, 'Grey Athletiq Hoodie', 'Neutral grey hoodie with Athletiq branding', @women_hoodies_cat_id, 30.00);

-- -----------------------------------------------------
-- Women's Tops (6–10)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(6, 'Athletiq Polo Tee', 'Comfortable polo tee for active wear', @women_tops_cat_id, 39.99),
(7, 'Athletiq Football Jersey', 'Performance football jersey', @women_tops_cat_id, 45.00),
(8, 'Athletiq Compression Top', 'High-performance compression top', @women_tops_cat_id, 40.00),
(9, 'Athletiq Cami-Tanktop', 'Lightweight cami tanktop for workouts', @women_tops_cat_id, 25.00),
(10, 'Athletiq Basketball Jersey', 'Breathable basketball jersey', @women_tops_cat_id, 45.00);

-- -----------------------------------------------------
-- Women's Bottoms (11–15)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(11, 'Athletiq Tennis Skort', 'Stylish tennis skort with built-in shorts', @women_bottoms_cat_id, 32.00),
(12, 'Athletiq Leggings', 'High-waisted performance leggings', @women_bottoms_cat_id, 35.00),
(13, 'Athletiq Swimming Shorts', 'Quick-dry swimming shorts', @women_bottoms_cat_id, 25.00),
(14, 'Athletiq Baggy Joggers', 'Comfortable baggy joggers for training', @women_bottoms_cat_id, 49.99),
(15, 'Athletiq Cycling Shorts', 'Padded cycling shorts for comfort', @women_bottoms_cat_id, 30.00);

-- -----------------------------------------------------
-- Women's Footwear (16–20)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(16, 'Womens Running Spikes', 'Professional running spikes for track', @women_footwear_cat_id, 85.99),
(17, 'Womens Flip Flops', 'Casual flip flops for post-workout', @women_footwear_cat_id, 20.00),
(18, 'Womens Running Shoes', 'Cushioned running shoes for training', @women_footwear_cat_id, 80.00),
(19, 'Womens Basketball Shoes', 'High-top basketball shoes with ankle support', @women_footwear_cat_id, 90.00),
(20, 'Womens Football Boots', 'Professional football boots with studs', @women_footwear_cat_id, 85.99);

-- -----------------------------------------------------
-- Women's Headwear (21–25)
-- -----------------------------------------------------

INSERT INTO product (product_id, name, description, category_id, price) VALUES
(21, 'Athletiq Visor', 'Sun visor for outdoor sports', @women_headwear_cat_id, 25.00),
(22, 'Athletiq Sweatband', 'Absorbent sweatband for intense workouts', @women_headwear_cat_id, 15.99),
(23, 'Athletiq Rugby Helmet', 'Protective rugby helmet with ear padding', @women_headwear_cat_id, 75.00),
(24, 'Athletiq Baseball Cap', 'Classic baseball cap with Athletiq logo', @women_headwear_cat_id, 35.00),
(25, 'Athletiq Swimcap', 'Silicone swimcap for competitive swimming', @women_headwear_cat_id, 10.99);

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
