import { usePage } from "@inertiajs/react";
import Echo from "laravel-echo";
import React, { useEffect } from "react";

const ChatLayout = ({ children }) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversations = page.props.selectedConversations;

    console.log("conversations", conversations);
    console.log("selectedConversations", selectedConversations);
    // TODO: 1:42:00
    useEffect(() => {
        window.Echo.join("online")
            .here((users) => {
                console.log("here", users);
            })
            .joining((user) => {
                console.log("joining", user);
            })
            .leaving((user) => {
                console.log("leaving", user);
            })
            .error((error) => {
                console.log("error", error);
            });

        return () => {
            window.Echo.leave("online");
        };
    }, []);

    // useEffect(() => {
    //     // Echo.join("online")
    //     //     .here((users) => {
    //     //         console.log("here", users);
    //     //     })
    //     //     .joining((user) => {
    //     //         console.log("joining", user);
    //     //     })
    //     //     .leaving((user) => {
    //     //         console.log("leaving", user);
    //     //     });
    // }, []);
    return (
        <>
            ChatLayout
            <>{children}</>
        </>
    );
};

export default ChatLayout;
