import React from "react";
import { useState, useEffect } from "react";
import { customAxios } from "../config";

const TagsSearch = () => {
    const [tags, setTags] = useState([]);
    const [search, setSearch] = useState("");
    const [loading, setLoading] = useState(false);

    // search the tag similar to the search word
    const searchTagData = () => {
        setLoading(true);
        customAxios
            .post("/tags", { search })
            .then(function (result) {
                setLoading(false);
                // add the similar named tags inside the tag state
                let similarTags = result.data.data.tags;
                if (similarTags && similarTags.length > 0) {
                    // if there are similar tags
                    setTags(similarTags);
                } else {
                    getInitialTags(); // get initial tags back
                }
            })
            .catch(function (err) {
                setLoading(false);
                console.log(err.message);
            });
    };

    // fettch the initial tags
    const getInitialTags = () => {
        customAxios
            .get("/tags")
            .then(function (result) {
                setTags(result.data.data.tags);
            })
            .catch(function (err) {
                console.log(err.response.data.errors.tagsError);
            });
    };

    // run get initial tags
    useEffect(() => {
        getInitialTags();
    }, []);

    /// get search tag
    useEffect(() => {
        const timeOutInstance = setTimeout(() => {
            //  wait for at least 1 second
            if (search) {
                // if search has value
                searchTagData();
            } else {
                // get initial tas
                getInitialTags();
            }
        }, 1000);

        return () => clearTimeout(timeOutInstance);
    }, [search]);

    return (
        <div>
            <div>
                <input
                    type="text"
                    value={search}
                    onChange={(e) => {
                        setSearch(e.target.value);
                    }}
                    className={`input-form-sky ${
                        loading ? "loading-image-form" : ""
                    }`}
                />
            </div>
            {tags.map((tag) => (
                <a
                    href={`/articles/global/search?tag=${tag.id}`}
                    className="text-black hover:no-underline"
                    key={tag.slug}
                >
                    <div className="hover:bg-slate-100 px-2 py-1 rounded-lg">
                        {tag.title}
                    </div>
                </a>
            ))}
        </div>
    );
};

export default TagsSearch;
