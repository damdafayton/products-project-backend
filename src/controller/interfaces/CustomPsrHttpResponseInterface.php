<?php

namespace controller\interfaces;

interface CustomPsrHttpResponseInterface
{
  /** FROM MessageInterface 
   * Return an instance with the provided value replacing the specified header.
   *
   * While header names are case-insensitive, the casing of the header will
   * be preserved by this function, and returned from getHeaders().
   *
   * This method MUST be implemented in such a way as to retain the
   * immutability of the message, and MUST return an instance that has the
   * new and/or updated header and value.
   *
   * @param string $name Case-insensitive header field name.
   * @param string|string[] $value Header value(s).
   * @return static
   * @throws \InvalidArgumentException for invalid header names or values.
   */
  public function withHeader($name, $value);


  /** FROM ResponseInterface 
   * Return an instance with the specified status code and, optionally, reason phrase.
   *
   * If no reason phrase is specified, implementations MAY choose to default
   * to the RFC 7231 or IANA recommended reason phrase for the response's
   * status code.
   *
   * This method MUST be implemented in such a way as to retain the
   * immutability of the message, and MUST return an instance that has the
   * updated status and reason phrase.
   *
   * @see http://tools.ietf.org/html/rfc7231#section-6
   * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
   * @param int $code The 3-digit integer result code to set.
   * @param string $reasonPhrase The reason phrase to use with the
   *     provided status code; if none is provided, implementations MAY
   *     use the defaults as suggested in the HTTP specification.
   * @return static
   * @throws \InvalidArgumentException For invalid status code arguments.
   */
  public function withStatus($code, $reasonPhrase = '');
}