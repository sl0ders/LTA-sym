import React, {useEffect, useState} from "react";
import ApiNews from "../Services/APIGetNews";

const RightComponent = () => {
    const [newss, setNews] = useState([]);

    const fetchNews = async () => {
        try {
            const data = await ApiNews.findAll(); // On insere les donnés recolté dans le tableau des customers qu'on a créer plus haut
            setNews(data);
        } catch (error) {
            console.log(error.response)// on rajoute un catch qui renvoi avec precision l'erreur qui peut avoir lieu
        }
    };

    useEffect( () => {
        fetchNews
    },[]);

    console.log(newss);
    return (
        <>
            <h1>Liste des news</h1>
            <div>
                {newss.map(
                news =>
                    <ul key={news}>
                        <li>{news.id}</li>
                        <li>{news.title}</li>
                        <li>{news.content}</li>
                    </ul>
            )}
            </div>
        </>

    )
};

export default RightComponent;



