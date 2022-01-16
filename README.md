A Symfony based REST API allowing user to see the comparsion of basic statistics for two schosen GitHub repositories.

To start the project:
- install dependenencies with 'composer install' command
- start the app on youtr localhost with Symfony-CLI 'symfony:server' command

The API accepts POST requests json body in the following format:

{
	"repositories": {
		"first_repo": "xxxxx",
		"second_repo": "yyyyy"
	}
}

The accepted repo name/url (for "first_repo" and "second_repo" arguments) formats are:

{owner}/{repo}
https://github.com/{owner}/{repo}
https://github.com/{owner}/{repo}.git
http://github.com/{owner}/{repo}
http://github.com/{owner}/{repo}.git

The api returns error infos with the BAD REQUEST status response code (400), for e.g.

{
  "errors": {
    "[repositories][first_repo]": "This value is not a valid github repository link or name.",
    "[repositories][second_repo]": "This value is not a valid github repository link or name."
  }
}

Or if the payload is well formatted it returns comparsion data with the OK status response code (200), for e.g:

{
  "forks": {
    "xxxxx: 8504,
    "yyyyy": 581,
    "winner": "xxxxx
  },
  "stars": {
    "xxxxx: 26339,
    "yyyyy": 1929,
    "winner": "xxxxx
  },
  "watchers": {
    "xxxxx: 26339,
    "yyyyy": 1929,
    "winner": "xxxxx
  },
  "latest_release": {
    "xxxxx: "2021-12-29T14:14:15Z",
    "yyyyy": "2021-12-08T07:25:28Z",
    "winner": "xxxxx
  },
  "open_pull_requests": {
    "xxxxx: 209,
    "yyyyy": 3,
    "winner": "xxxxx
  },
  "closed_pull_requests": {
    "xxxxx: 26844,
    "yyyyy": 654,
    "winner": "xxxxx
  },
  "winner": "xxxxx
}
