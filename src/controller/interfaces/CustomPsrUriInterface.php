<?php

/**
 * Here I've grouped the methods which are also included in PSR HTTP UriInterface.
 * These methods are enough to run this app. Hence I didnt implement the whole interface.
 * They are documented here in case a fully PSR compliant frame-work will be developed in the future.
 */

namespace controller\interfaces;

/**
 * Value object representing a URI.
 *
 * This interface is meant to represent URIs according to RFC 3986 and to
 * provide methods for most common operations. Additional functionality for
 * working with URIs can be provided on top of the interface or externally.
 * Its primary use is for HTTP requests, but may also be used in other
 * contexts.
 *
 * Instances of this interface are considered immutable; all methods that
 * might change state MUST be implemented such that they retain the internal
 * state of the current instance and return an instance that contains the
 * changed state.
 *
 * Typically the Host header will also be present in the request message.
 * For server-side requests, the scheme will typically be discoverable in the
 * server parameters.
 *
 * @see http://tools.ietf.org/html/rfc3986 (the URI specification)
 */
interface CustomPsrUriInterface
{
  /**
   * Retrieve the path component of the URI.
   *
   * The path can either be empty or absolute (starting with a slash) or
   * rootless (not starting with a slash). Implementations MUST support all
   * three syntaxes.
   *
   * Normally, the empty path "" and absolute path "/" are considered equal as
   * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
   * do this normalization because in contexts with a trimmed base path, e.g.
   * the front controller, this difference becomes significant. It's the task
   * of the user to handle both "" and "/".
   *
   * The value returned MUST be percent-encoded, but MUST NOT double-encode
   * any characters. To determine what characters to encode, please refer to
   * RFC 3986, Sections 2 and 3.3.
   *
   * As an example, if the value should include a slash ("/") not intended as
   * delimiter between path segments, that value MUST be passed in encoded
   * form (e.g., "%2F") to the instance.
   *
   * @see https://tools.ietf.org/html/rfc3986#section-2
   * @see https://tools.ietf.org/html/rfc3986#section-3.3
   * @return string The URI path.
   */
  public function getPath();

  /**
   * Retrieve the query string of the URI.
   *
   * If no query string is present, this method MUST return an empty string.
   *
   * The leading "?" character is not part of the query and MUST NOT be
   * added.
   *
   * The value returned MUST be percent-encoded, but MUST NOT double-encode
   * any characters. To determine what characters to encode, please refer to
   * RFC 3986, Sections 2 and 3.4.
   *
   * As an example, if a value in a key/value pair of the query string should
   * include an ampersand ("&") not intended as a delimiter between values,
   * that value MUST be passed in encoded form (e.g., "%26") to the instance.
   *
   * @see https://tools.ietf.org/html/rfc3986#section-2
   * @see https://tools.ietf.org/html/rfc3986#section-3.4
   * @return string The URI query string.
   */
  public function getQuery();

  /**
   * Retrieve the fragment component of the URI.
   *
   * If no fragment is present, this method MUST return an empty string.
   *
   * The leading "#" character is not part of the fragment and MUST NOT be
   * added.
   *
   * The value returned MUST be percent-encoded, but MUST NOT double-encode
   * any characters. To determine what characters to encode, please refer to
   * RFC 3986, Sections 2 and 3.5.
   *
   * @see https://tools.ietf.org/html/rfc3986#section-2
   * @see https://tools.ietf.org/html/rfc3986#section-3.5
   * @return string The URI fragment.
   */
}