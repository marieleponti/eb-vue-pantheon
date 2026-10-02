# WordPress Backend — Technical README

**Last updated:** October 2026
**Scope:** Technical reference for this repository. Security status, infrastructure details, and pending hardening items are tracked in a separate internal document (not kept in this repository).

---

## 1. What This Is

A **headless WordPress installation** — it serves content exclusively via the REST API to a separate frontend application (Vue.js). There is no theme rendering pages for public visitors; wp-admin is used only by internal staff to manage content.

```
Frontend (separate repository/hosting)
        │
        │  HTTPS requests, JWT Bearer token
        ▼
WordPress REST API  ← this repository
        │
        ▼
MySQL database
```

---

## 2. Custom Code — Where It Lives

| Location | Purpose |
|---|---|
| Theme `functions.php` | Custom role/capability definitions, REST API CORS filter |
| `ebinforepo.php` (mu-plugin/theme include) | Active REST route registrations under the `ebinforepo/v1` namespace: `/resources`, `/me`, `/filters` |
| `helpers.php` (or equivalent) | Query logic and response formatting for the `/resources` endpoint, including a custom taxonomy tree builder used for frontend filters |

All custom REST endpoints live under the `ebinforepo/v1` namespace. There is no other active custom namespace.

---

## 3. Custom Roles & Capabilities

| Role | Capabilities | Purpose |
|---|---|---|
| `eb_team` | `read_private_posts`, `edit_posts`, `edit_published_posts`, `publish_posts` | Internal staff — full content management |
| `eb_community_member` | `read_private_posts` | Can view non-public content, cannot edit |

Content visibility (`publish` vs `private` status) is enforced **server-side**, based on these capabilities — this is not just a frontend display filter. See `get_resources_handler()` in `helpers.php`.

---

## 4. Authentication

- **Method:** JWT, via the **JWT Authentication for WP-API** plugin (Tmeister / `wp-api-jwt-auth`).
- **Token expiration:** 4 hours, configured via the `jwt_auth_expire` filter in `functions.php`.
- Authentication is for internal team use only — there is no public user registration or public-facing login flow tied to this backend.
- `JWT_AUTH_SECRET_KEY` is set in `wp-config.php` (not committed — see your local `.env`/secrets manager). If it is ever rotated, all active sessions are invalidated immediately (expected behavior).

---

## 5. REST API Endpoints

| Route | Method | Auth | Purpose |
|---|---|---|---|
| `ebinforepo/v1/resources` | GET | Optional (affects visibility) | Returns resources; includes `private`-status items only for authorized roles |
| `ebinforepo/v1/me` | GET | Required (Bearer token) | Returns current user's id/roles/capabilities |
| `ebinforepo/v1/filters` | GET | None | Returns the taxonomy tree used by the frontend's filter UI |
| `jwt-auth/v1/token` | POST | Credentials | Standard JWT plugin login endpoint |

---

## 6. CORS

`functions.php` overrides WordPress's default REST CORS handling to allow only specific frontend origins (local development + the deployed frontend domain). Update the allowlist whenever the frontend's domain changes.

---

## 7. Content Model

- No public content submission forms.
- No public user registration.
- No write access to content from the frontend — content is managed exclusively via wp-admin by internal staff.
- No `Page` post type content in use — this is a headless setup built entirely on `post` and a custom `inforepo_resource` post type.

---

## 8. Local Development

Standard WordPress local setup applies (e.g. Local, DDEV, or Pantheon's local tooling). Required environment values:

- `JWT_AUTH_SECRET_KEY` — long, random string
- `JWT_AUTH_CORS_ENABLE` — `true`
- Database credentials per your local environment

Ask the maintainer for a sanitized database export or seed data if you need realistic content to develop against.