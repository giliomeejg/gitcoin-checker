# Checker

Leveraging the Gitcoin Indexer, this tool simplifies the process for round managers to select projects for inclusion. By defining specific evaluation criteria, managers can utilize ChatGPT for automated project assessments and scoring.

## Development

The project uses Laravel and Vuejs, with Inertia for serving up the SPA.

## To launch with Docker

```
make up
```

## To ssh into the container and run npm

```
make in
npm run dev
```

http://localhost

## Tests

```
make in
make test
```
