import React, { useEffect, useState } from 'react';
import { Button, Rating, Spinner, Dropdown } from 'flowbite-react';
import { FaArrowDown91,FaArrowDown19 } from "react-icons/fa6";

const App = props => {
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchMovies = (queryParameters = {}) => {
    let url = "http://localhost:8000/movies"
    if(Object.keys(queryParameters).length !== 0) {
    const params = new URLSearchParams(queryParameters);
     url += '?' + params
    }
    setLoading(true);
    return fetch(url)
      .then(response => response.json())
      .then(data => {
        setMovies(data);
        setLoading(false);
      });
  }
  const onSorting = (queryParameters) => {
    fetchMovies(queryParameters);
  }

  const onSelectGenres  = (queryParameters) => {
    fetchMovies(queryParameters);
  }

  useEffect(() => {
    fetchMovies();
  }, []);

  return (
    <Layout>
      <Heading />
        <SearchBar onSorting={onSorting} onSelectGenres={onSelectGenres} />
      <MovieList loading={loading}>
        {movies.map((item, key) => (
          <MovieItem key={key} {...item} />
        ))}
      </MovieList>
    </Layout>
  );
};

const Layout = props => {
  return (
    <section className="bg-white dark:bg-gray-900">
      <div className="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        {props.children}
      </div>
    </section>
  );
};

const Heading = props => {
  return (
    <div className="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
      <h1 className="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
        Movie Collection
      </h1>

      <p className="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">
        Explore the whole collection of movies
      </p>
    </div>
  );
};

const MovieList = props => {
  if (props.loading) {
    return (
      <div className="text-center">
        <Spinner size="xl" />
      </div>
    );
  }

  return (
    <div className="grid gap-4 md:gap-y-8 xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3">
      {props.children}
    </div>
  );
};

const MovieItem = props => {
  return (
    <div className="flex flex-col w-full h-full rounded-lg shadow-md lg:max-w-sm">
      <div className="grow">
        <img
          className="object-cover w-full h-60 md:h-80"
          src={props.imageUrl}
          alt={props.title}
          loading="lazy"
        />
      </div>

      <div className="grow flex flex-col h-full p-3">
        <div className="grow mb-3 last:mb-0">
          {props.year || props.rating
            ? <div className="flex justify-between align-middle text-gray-900 text-xs font-medium mb-2">
                <span>{props.year}</span>

                {props.rating
                  ? <Rating>
                      <Rating.Star />

                      <span className="ml-0.5">
                        {props.rating}
                      </span>
                    </Rating>
                  : null
                }
              </div>
            : null
          }

          <h3 className="text-gray-900 text-lg leading-tight font-semibold mb-1">
            {props.title}
          </h3>

          <p className="text-gray-600 text-sm leading-normal mb-4 last:mb-0">
            {props.plot.substr(0, 80)}...
          </p>
        </div>

        {props.wikipediaUrl
          ? <Button
              color="light"
              size="xs"
              className="w-full"
              onClick={() => window.open(props.wikipediaUrl, '_blank')}
            >
              More
            </Button>
          : null
        }
      </div>
    </div>
  );
};



const SearchBar = ({onSorting, onSelectGenres}) => {
 const [genres, setGenres] = useState([]);

  useEffect(() => {
    fetch('http://localhost:8000/genres')
      .then(response => response.json())
      .then(data => {
        setGenres(data);
      })},
      []
  );

  const changeSort = (type) => {
  let sort = null;
  if(type == "ASC") {
    sort = "DESC";
  }
  if(type == null) {
    sort ="ASC"
  }

  return sort;
}
  const [sorts, setSorts] = useState({
      rating: null,
      release: null,
      genres: null,
    });


  const handleSort= (value) => {
    let result = sorts;
     if(value == 'ACTION_RATE') {
          result = {...result, rating: changeSort(result.rating)}
     }

     if(value == 'ACTION_REALESE') {
       result = {...result, release: changeSort(result.release)}
     }

     setSorts(result);

    onSorting(result);
  };

  const handleDropdownChange = (value) => {
    var result = {...sorts, genres : value}
    setSorts(result);
    onSelectGenres(result);
  };

  return (
    <div className='flex flex-row justify-between mb-20'>
      <Dropdown color="gray" label={(sorts.genres)? sorts.genres : "All"} onChange={(e) => handleDropdownChange(e)}>
        <Dropdown.Item  onClick={() => handleDropdownChange(null)}>All</Dropdown.Item>
        {
          genres.map((item, index) =>
            {
             return <Dropdown.Item onClick={() => handleDropdownChange(item.name)} key={index}>{item.name}</Dropdown.Item>
            }
          )
        }
      </Dropdown>
      <Button.Group>
        <Button color="gray" onClick={() => handleSort('ACTION_RATE')}>
          Ordina per voto {sorts.rating ===  "ASC"? <FaArrowDown19 size={20} /> : sorts.rating ===  "DESC"? <FaArrowDown91 size={20} /> : null}
        </Button>
        <Button color="gray" onClick={() => handleSort('ACTION_REALESE')}>
          Ordina per uscita {sorts.release ===  "ASC"? <FaArrowDown19 size={20} /> : sorts.release ===  "DESC"? <FaArrowDown91 size={20} /> : null}
        </Button>
       </Button.Group>
    </div>
  );
}
export default App;
