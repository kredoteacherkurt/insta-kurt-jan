-- INSERT data in category table
-- Travel, Food, Lifestyle, Music, Career, Movie
INSERT INTO categories (name) VALUES 
('Travel'),
('Food'),
('Lifestyle'),
('Music'),
('Career'),
('Movie');

-- sample post about cupcake
INSERT INTO posts (title, content, category_id) VALUES 
('Cupcake', 'Cupcake ipsum dolor sit amet. Jelly beans jelly beans jelly beans 
jelly beans. Toffee jelly beans jelly beans. Toffee jelly beans jelly beans.
Topping jelly beans jelly beans jelly beans jelly beans. Toffee jelly beans');


-- why do we need to use foreign key?
-- to make sure that the data is valid and consistent in both tables (parent and child)
-- if we delete the parent, the child will be deleted too (cascade) 

-- Many to Many Relationship
---It is a relationship between two tables where one record in either table can be related to many records in the other table and vice versa.
-- We need to create a new table to connect the two tables (posts and categories) 
-- this table is called posts_categories
-- this table will have two columns (post_id, category_id)
-- this table will have two foreign keys (post_id, category_id)
-- this table will have two primary keys (post_id, category_id)
-- it will serve as a bridge between the two tables (posts and categories) or a junction table

-- why do we need to use a junction table?
-- to avoid redundancy and to make sure that the data is valid and consistent in both tables (parent and child)
--  without the junction table, we will have to repeat the data in both tables (posts and categories)
--