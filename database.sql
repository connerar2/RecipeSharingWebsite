create table users (
	username varchar(32) primary key,
	password varchar(60) not null
);

create table Ingredients (
	ingredient text primary key
);

create table Recipe (
	id int primary key auto-increment,
	owner text not null,
	recipe_name text not null,
	description text not null,
	meal_image text not null,
	filename text not null
);
	
create table recipe_ingredient (
	recipe_id int,
	ingredient varchar(100),
	foreign key (recipe_id) references Recipe(id),
	foreign key (ingredient) references Ingredients(ingredient),
	primary key(recipe_id, ingredient)
);
