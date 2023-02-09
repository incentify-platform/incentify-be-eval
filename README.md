# Setup
## Getting started:

Follow these instructions to get the app running with docker compose locally:

From the project root, run 
`cp .env.example .env` then `composer install` then `./vendor/bin/sails up`

After this, in another terminal bash into the docker container using: `./vendor/bin/sail shell`

From within this shell, you may run `php artisan migrate:fresh --seed` but the seeder will take quite a long time to complete. Instead, I would suggest that you use the gzipped mysql backup found in this project (which is the result of the previous command) `database/tech_eval.gz` and restore from this file to your local database. 

Once this step is complete, choose any user you like to login with, all user passwords should be `123Ez`, and I would suggest you initially do so with a user who is a primary_user on one or more tenants.

To login, go to `http://localhost/dashboard` in your browser, you will be brought to the login screen if you're not already logged in. After logging in with username/pass You should see that the dashboard shows you an accessToken in an input field on the page. Go ahead and copy this value (currently they don't expire) to use in your http / graphql client of choice for making API calls.

Below is a basic query to get information about the currently logged in Member, it not logged in this query will fail as unauthorized.
```
query foo {
	me {
		id
		isActive
		createdAt
		updatedAt
		user {
			id
			name
			email
			createdAt
			updatedAt
			memberships {
				id
				isActive
				tenant {
					id
				}
			}
		}
		tenant {
			id
			type
			title
			primaryUser {
				id
				email
			}
			createdAt
			updatedAt
			parent {
				id
				type
				title
				primaryUser {
					id
					email
				}
				createdAt
				updatedAt
			}
			children {
				id
				type
				title
				primaryUser {
					id
					email
				}
				createdAt
				updatedAt
			}
		}
	}
}
```
The schema endpoint is `http://localhost/graphql` and you must pass the header `Authorization` with the value `Bearer {{ _.accessToken }}` where the accessToken value is what you coppied form the logged in dashboard page.

Please take a moment to inspect the db migrations, seeders, and factories to get a general sense of the overall data structure we are working with. Some high level points here are:
* Tenants all have a primary user. This user should be able to perform any action
* Tenants may have a parent tenant. Child tenants may only see their individual data, but a parent tenant may see data from all children.
* Users have an email and password
* A member is the context of a user with a tenant. Actions are performed as a member, rather than a user. This is why entity access and created by are tracked for members rather than users.
* The basic core data types present are Site and Legal Entity.
* A site may be associated with a single Legal Entity or not, meaning that a legal entity has 0->n sites. Sites might have an address / discreet location
* Entity access is granted on a per member basis to individual legal entity or site rows.


# Challenges:

For performing these challenges, we would like you to fork this public repo into your own in which your changes will be pushed.

### Things we would hope to see in your implementation:
* Use of Interfaces and bound dependencies which are injected to graph queries and mutations.
* Logic abstracted out of graph query and mutation classes into an injected service.
* Use of Doctrine DQL and Paginated result sets.
* All GraphQL Queries and Mutations require a member authenticated via Authorization header. (see the existing me call for an example, feel free to abstract this)

## #1: Create GraphQL Query to get a list of sites
* Add a new query to the graph schema called `sites` which returns a list of sites for the currently logged in member.
* This should return all sites for the current member tenant, and any child tenants.
* Optional query arguments for legalEntityId and tenantId which filter the db query to only sites belonging to that particular tenant or legalEntity.
* DB Query and graph response should be paginated (not required but would be nice to see)

## #2: Create GraphQL Query to get a list of legal entities
* Add a new query to the graph schema called `legalEntities` which returns a list of sites for the currently logged in member. If the member tenant has child tenants
* This should return all sites for the current member tenant, and any child tenants.
* DB Query and graph response should be paginated (not required but would be nice to see)

## #3: Adjust both GraphQL Queries above to respect entity access
* Implement the following rules:
    * The primaryUser of any tenant should have access to all data regardless of rows in entity_access
    * ANY member of a parent tenant should have access to all child tenant data regardless of rows in entity_access
    * If a member is the createdBy member for a site or legal entity they should have access regardless of rows in entity_access
    * In all other cases, for a member to have access they must have a row in entity_access for the entity(site or legal entity) and their member id.
    * Since there is a parent/child relationship between legalEntity and site, if a member has entity_access granted to a legalEntity, all sites of that legal entity should also be accessible regardless of rows in entity_access for those sites. (not required but would be nice to see)
* Ensure that data returned from graph is limited according to the above rules 

## #4: A mutation to create a site along with entity access
* Create a new mutation called `createSite` which uses input types. This should take nullable address information as well as an optional legalEntity id. This should also take a list of 0->n member ids to grant access to.
* Persist this data and return the result
* Ensure the currently authenticated member has entity access to the referenced legalEntity if provided. (not required but would be nice to see)
* Ensure that member(s) granted access are in fact members of the currently authenticated member tenant. (not required but would be nice to see)




