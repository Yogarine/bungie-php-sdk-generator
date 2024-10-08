<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI;

enum HttpStatusCode: int
{
    /**
     * The 100 (Continue) status code indicates that the initial part of a
     * request has been received and has not yet been rejected by the
     * server.  The server intends to send a final response after the
     * request has been fully received and acted upon.
     */
    case Continue = 100;

    /**
     * The 101 (Switching Protocols) status code indicates that the server
     * understands and is willing to comply with the client's request, via
     * the Upgrade header field, for a change in the application protocol
     * being used on this connection. The server MUST generate an Upgrade
     * header field in the response that indicates which protocol(s) will be
     * in effect after this response.
     *
     * It is assumed that the server will only agree to switch protocols
     * when it is advantageous to do so. For example, switching to a newer
     * version of HTTP might be advantageous over older versions, and
     * switching to a real-time, synchronous protocol might be advantageous
     * when delivering resources that use such features.
     */
    case SwitchingProtocols = 101;

    /**
     * The 102 (Processing) status code is an interim response used to
     * inform the client that the server has accepted the complete request,
     * but has not yet completed it.  This status code SHOULD only be sent
     * when the server has a reasonable expectation that the request will
     * take significant time to complete. As guidance, if a method is taking
     * longer than 20 seconds (a reasonable, but arbitrary value) to process
     * the server SHOULD return a 102 (Processing) response. The server MUST
     * send a final response after the request has been completed.
     *
     * Methods can potentially take a long period of time to process,
     * especially methods that support the Depth header.  In such cases the
     * client may time-out the connection while waiting for a response.  To
     * prevent this the server may return a 102 (Processing) status code to
     * indicate to the client that the server is still processing the
     * method.
     */
    case Processing = 102;

    /**
     * The 103 (Early Hints) informational status code indicates to the
     * client that the server is likely to send a final response with the
     * header fields included in the informational response.
     *
     * Typically, a server will include the header fields sent in a 103
     * (Early Hints) response in the final response as well.  However, there
     * might be cases when this is not desirable, such as when the server
     * learns that the header fields in the 103 (Early Hints) response are
     * not correct before the final response is sent.
     *
     * A client can speculatively evaluate the header fields included in a
     * 103 (Early Hints) response while waiting for the final response.  For
     * example, a client might recognize a Link header field value
     * containing the relation type "preload" and start fetching the target
     * resource.  However, these header fields only provide hints to the
     * client; they do not replace the header fields on the final response.
     *
     * Aside from performance optimizations, such evaluation of the 103
     * (Early Hints) response's header fields MUST NOT affect how the final
     * response is processed.  A client MUST NOT interpret the 103 (Early
     * Hints) response header fields as if they applied to the informational
     * response itself (e.g., as metadata about the 103 (Early Hints)
     * response).
     *
     * A server MAY use a 103 (Early Hints) response to indicate only some
     * of the header fields that are expected to be found in the final
     * response.  A client SHOULD NOT interpret the nonexistence of a header
     * field in a 103 (Early Hints) response as a speculation that the
     * header field is unlikely to be part of the final response.
     */
    case EarlyHints = 103;

    /**
     * The 200 (OK) status code indicates that the request has succeeded.
     * The content sent in a 200 response depends on the request method. For
     * the methods defined by this specification, the intended meaning of
     * the content can be summarized as:
     *
     * | Request Method | Response content is a representation of:            |
     * |----------------|-----------------------------------------------------|
     * | GET            | the target resource                                 |
     * | HEAD           | like GET, but without the representation data       |
     * | POST           | the status of, or results obtained from, the action |
     * | PUT, DELETE    | the status of the action                            |
     * | OPTIONS        | communication options for the target resource       |
     * | TRACE          | the request message as received by the server       |
     *
     * Aside from responses to CONNECT, a 200 response is expected to
     * contain message content unless the message framing explicitly
     * indicates that the content has zero length. If some aspect of the
     * request indicates a preference for no content upon success, the
     * origin server ought to send a 204 (No Content) response instead. For
     * CONNECT, there is no content because the successful result is a
     * tunnel, which begins immediately after the 200 response header
     * section.
     */
    case OK = 200;

    /**
     * The 201 (Created) status code indicates that the request has been
     * fulfilled and has resulted in one or more new resources being created.
     * The primary resource created by the request is identified by either a
     * Location header field in the response or, if no Location header field
     * is received, by the target URI.
     *
     * The 201 response content typically describes and links to the resource(s)
     * created. Any validator fields (Section 8.8) sent in the response convey
     * the current validators for a new representation created by the request.
     * Note that the PUT method (Section 9.3.4) has additional requirements
     * that might preclude sending such validators.
     */
    case Created = 201;

    /**
     * The 202 (Accepted) status code indicates that the request has been
     * accepted for processing, but the processing has not been completed.
     * The request might or might not eventually be acted upon, as it might
     * be disallowed when processing actually takes place. There is no facility
     * in HTTP for re-sending a status code from an asynchronous operation.
     *
     * The 202 response is intentionally noncommittal. Its purpose is to allow
     * a server to accept a request for some other process (perhaps a batch-
     * oriented process that is only run once per day) without requiring that
     * the user agent's connection to the server persist until the process is
     * completed. The representation sent with this response ought to describe
     * the request's current status and point to (or embed) a status monitor
     * that can provide the user with an estimate of when the request will be
     * fulfilled.
     */
    case Accepted = 202;

    /**
     * The 203 (Non-Authoritative Information) status code indicates that the
     * request was successful but the enclosed content has been modified from
     * that of the origin server's 200 (OK) response by a transforming proxy.
     * This status code allows the proxy to notify recipients when a
     * transformation has been applied, since that knowledge might impact
     * later decisions regarding the content. For example, future cache
     * validation requests for the content might only be applicable along the
     * same request path (through the same proxies).
     */
    case NonAuthoritativeInformation = 203;

    /**
     * The 204 (No Content) status code indicates that the server has
     * successfully fulfilled the request and that there is no additional
     * content to send in the response content. Metadata in the response
     * header fields refer to the target resource and its selected
     * representation after the requested action was applied.
     *
     * For example, if a 204 status code is received in response to a PUT
     * request and the response contains an ETag field, then the PUT was
     * successful and the ETag field value contains the entity tag for the
     * new representation of that target resource.
     *
     * The 204 response allows a server to indicate that the action has been
     * successfully applied to the target resource, while implying that the
     * user agent does not need to traverse away from its current "document
     * view" (if any). The server assumes that the user agent will provide
     * some indication of the success to its user, in accord with its own
     * interface, and apply any new or updated metadata in the response to
     * its active representation.
     *
     * For example, a 204 status code is commonly used with document editing
     * interfaces corresponding to a "save" action, such that the document
     * being saved remains available to the user for editing. It is also
     * frequently used with interfaces that expect automated data transfers
     * to be prevalent, such as within distributed version control systems.
     *
     * A 204 response is terminated by the end of the header section; it
     * cannot contain content or trailers.
     */
    case NoContent = 204;

    /**
     * The 205 (Reset Content) status code indicates that the server has
     * fulfilled the request and desires that the user agent reset the "document
     * view", which caused the request to be sent, to its original state as
     * received from the origin server.
     *
     * This response is intended to support a common data entry use case where
     * the user receives content that supports data entry (a form, notepad,
     * canvas, etc.), enters or manipulates data in that space, causes the
     * entered data to be submitted in a request, and then the data entry
     * mechanism is reset for the next entry so that the user can easily
     * initiate another input action.
     *
     * Since the 205 status code implies that no additional content will be
     * provided, a server MUST NOT generate content in a 205 response.
     */
    case ResetContent = 205;


}
