<?php

/**
 * Here I've grouped the methods which are also included in PSR HTTP.
 * These methods are enough to run this app. Hence I didnt implement the whole PSR.
 * They are documented here in case a fully PSR compliant frame-work will be developed in the future.
 */

namespace controller\interfaces;

interface CustomPsrHttpRequestInterface
{
  /** FROM RequestInterface
   * Retrieves the HTTP method of the request.
   *
   * @return string Returns the request method.
   */
  public function getMethod();


  /** FROM RequestInterface
   * Retrieves the URI instance.
   *
   * This method MUST return a UriInterface instance.
   *
   * @see http://tools.ietf.org/html/rfc3986#section-4.3
   * @return UriInterface Returns a UriInterface instance
   *     representing the URI of the request.
   */
  public function getUri();


  /** FROM ServerRequestInterface
   * Retrieve query string arguments.
   *
   * Retrieves the deserialized query string arguments, if any.
   *
   * Note: the query params might not be in sync with the URI or server
   * params. If you need to ensure you are only getting the original
   * values, you may need to parse the query string from `getUri()->getQuery()`
   * or from the `QUERY_STRING` server param.
   *
   * @return array
   */
  public function getQueryParams();


  /** FROM ServerRequestInterface
   * Retrieve any parameters provided in the request body.
   *
   * If the request Content-Type is either application/x-www-form-urlencoded
   * or multipart/form-data, and the request method is POST, this method MUST
   * return the contents of $_POST.
   *
   * Otherwise, this method may return any results of deserializing
   * the request body content; as parsing returns structured content, the
   * potential types MUST be arrays or objects only. A null value indicates
   * the absence of body content.
   *
   * @return null|array|object The deserialized body parameters, if any.
   *     These will typically be an array or object.
   */
  public function getParsedBody();
}