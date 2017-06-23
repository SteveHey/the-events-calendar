<?php

/**
 * Class Tribe__Events__REST__V1__Endpoints__Single_Organizer
 *
 * @since bucket/full-rest-api
 */
class Tribe__Events__REST__V1__Endpoints__Single_Organizer
	extends Tribe__Events__REST__V1__Endpoints__Linked_Post_Base
	implements Tribe__Events__REST__V1__Endpoints__Linked_Post_Endpoint_Interface,
	Tribe__Documentation__Swagger__Provider_Interface {

	/**
	 * Handles GET requests on the endpoint.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_Error|WP_REST_Response An array containing the data on success or a WP_Error instance on failure.
	 *
	 * @since bucket/full-rest-api
	 */
	public function get( WP_REST_Request $request ) {
		$organizer = get_post( $request['id'] );

		$cap = get_post_type_object( Tribe__Events__Main::VENUE_POST_TYPE )->cap->read_post;
		if ( ! ( 'publish' === $organizer->post_status || current_user_can( $cap, $request['id'] ) ) ) {
			$message = $this->messages->get_message( 'organizer-not-accessible' );

			return new WP_Error( 'organizer-not-accessible', $message, array( 'status' => 403 ) );
		}

		$data = $this->post_repository->get_organizer_data( $request['id'] );

		return is_wp_error( $data ) ? $data : new WP_REST_Response( $data );
	}

	/**
	 * Handles POST requests on the endpoint.
	 *
	 * @param WP_REST_Request $request
	 * @param bool            $return_id Whether the created post ID should be returned or the full response object.
	 *
	 * @return WP_Error|WP_REST_Response|int An array containing the data on success or a WP_Error instance on failure.
	 *
	 * @since bucket/full-rest-api
	 */
	public function create( WP_REST_Request $request, $return_id = false ) {
		$post_date = isset( $request['date'] ) ? Tribe__Date_Utils::reformat( $request['date'], 'Y-m-d H:i:s' ) : false;
		$post_date_gmt = isset( $request['date_utc'] ) ? Tribe__Timezones::localize_date( 'Y-m-d H:i:s', $request['date_utc'], 'UTC' ) : false;

		$post_status = $this->scale_back_post_status( $request['status'], Tribe__Events__Main::POSTTYPE );
		$postarr     = array(
			$this->get_id_index() => $request['id'],
			'post_author'         => $request['author'],
			'post_date'           => $post_date,
			'post_date_gmt'       => $post_date_gmt,
			'post_status'         => $post_status,
			'Organizer'           => $request['organizer'],
			'Description'         => $request['description'],
			'Phone'               => $request['phone'],
			'Website'             => $request['website'],
			'Email'               => $request['email'],
			'FeaturedImage'       => tribe_upload_image( $request['image'] ),
		);

		/**
		 * Filters whether the API should try to avoid inserting duplicate organizers or not.
		 *
		 * @param bool  $avoid_duplicates
		 * @param array $postarr The organizer data provided in the request.
		 *
		 * @since TBD
		 */
		$avoid_duplicates = apply_filters( 'tribe_events_rest_organizer_insert_avoid_duplicates', true, $postarr );

		$id = Tribe__Events__Organizer::instance()->create( array_filter( $postarr ), $post_status, $avoid_duplicates );

		if ( empty( $id ) ) {
			$message = $this->messages->get_message( 'could-not-create-organizer' );

			return new WP_Error( 'could-not-create-organizer', $message, array( 'status' => 400 ) );
		}

		if ( $return_id ) {
			return $id;
		}

		$data = $this->post_repository->get_organizer_data( $id );

		$response = new WP_REST_Response( $data );
		$response->set_status( 201 );

		return $response;
	}

	/**
	 * Inserts one or more organizers.
	 *
	 * @param int|array $data Either an existing linked post ID or the linked post data or an array of the previous options.
	 *
	 * @return false|array|WP_Error `false` if the linked post data is empty, the linked post ID (in an array as requested by the
	 *                              linked posts engine) or a `WP_Error` if the linked post insertion failed.
	 *
	 * @since bucket/full-rest-api
	 */
	public function insert( $data ) {
		$data = (array) $data;

		$inserted = array();
		foreach ( $data as $entry ) {
			$organizer_id = parent::insert( $entry );

			if ( $organizer_id instanceof WP_Error ) {
				return $organizer_id;
			}

			$inserted[] = $organizer_id;
		}

		return array( $this->get_id_index() => wp_list_pluck( $inserted, $this->get_id_index() ) );
	}

	/**
	 * Returns an array in the format used by Swagger 2.0.
	 *
	 * While the structure must conform to that used by v2.0 of Swagger the structure can be that of a full document
	 * or that of a document part.
	 * The intelligence lies in the "gatherer" of informations rather than in the single "providers" implementing this
	 * interface.
	 *
	 * @link  http://swagger.io/
	 *
	 * @return array An array description of a Swagger supported component.
	 *
	 * @since bucket/full-rest-api
	 */
	public function get_documentation() {
		$GET_defaults = $DELETE_defaults = array( 'in' => 'query', 'default' => '', 'type' => 'string' );
		$POST_defaults = array( 'in' => 'body', 'default' => '', 'type' => 'string' );

		return array(
			'get'  => array(
				'parameters' => $this->swaggerize_args( $this->READ_args(), $GET_defaults ),
				'responses'  => array(
					'200' => array(
						'description' => __( 'Returns the data of the organizer with the specified post ID', 'the-event-calendar' ),
						'schema'      => array(
							'$ref' => '#/definitions/Organizer',
						),
					),
					'400' => array(
						'description' => __( 'The organizer post ID is missing.', 'the-events-calendar' ),
					),
					'403' => array(
						'description' => __( 'The organizer with the specified ID is not accessible.', 'the-events-calendar' ),
					),
					'404' => array(
						'description' => __( 'An organizer with the specified event does not exist.', 'the-events-calendar' ),
					),
				),
			),
			'post' => array(
				'parameters' => $this->swaggerize_args( $this->CREATE_args(), $POST_defaults ),
				'responses'  => array(
					'201' => array(
						'description' => __( 'Returns the data of the created organizer', 'the-event-calendar' ),
						'schema'      => array(
							'$ref' => '#/definitions/Organizer',
						),
					),
					'400' => array(
						'description' => __( 'A required parameter is missing or an input parameter is in the wrong format', 'the-events-calendar' ),
					),
					'403' => array(
						'description' => __( 'The user is not authorized to create organizers', 'the-events-calendar' ),
					),
				),
			),
			'delete'  => array(
				'parameters' => $this->swaggerize_args( $this->DELETE_args(), $DELETE_defaults ),
				'responses'  => array(
					'200' => array(
						'description' => __( 'Deletes an organizer and returns its data', 'the-event-calendar' ),
						'schema'      => array(
							'$ref' => '#/definitions/Organizer',
						),
					),
					'400' => array(
						'description' => __( 'The organizer post ID is missing or does not exist.', 'the-venues-calendar' ),
					),
					'403' => array(
						'description' => __( 'The current user cannot delete the organizer with the specified ID.', 'the-venues-calendar' ),
					),
					'410' => array(
						'description' => __( 'The organizer with the specified ID has been deleted already.', 'the-venues-calendar' ),
					),
					'500' => array(
						'description' => __( 'The organizer with the specified ID could not be deleted.', 'the-venues-calendar' ),
					),
				),
			),
		);
	}

	/**
	 * Returns the content of the `args` array that should be used to register the endpoint
	 * with the `register_rest_route` function.
	 *
	 * @return array
	 *
	 * @since bucket/full-rest-api
	 */
	public function READ_args() {
		return array(
			'id' => array(
				'in'                => 'path',
				'type'              => 'integer',
				'description'       => __( 'the organizer post ID', 'the-events-calendar' ),
				'required'          => true,
				'validate_callback' => array( $this->validator, 'is_organizer_id' ),
			),
		);
	}

	/**
	 * Returns the content of the `args` array that should be used to register the endpoint
	 * with the `register_rest_route` function.
	 *
	 * @return array
	 *
	 * @since bucket/full-rest-api
	 */
	public function CREATE_args() {
		return array(
			// Post fields
			'author'      => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_user_id' ) ),
			'date'        => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_time' ) ),
			'date_utc'    => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_time' ) ),
			'organizer'   => array( 'required' => true, 'validate_callback' => array( $this->validator, 'is_string' ) ),
			'description' => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_string' ) ),
			'status'      => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_post_status' ) ),
			// Organizer meta fields
			'phone'       => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_string' ) ),
			'website'     => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_url' ) ),
			'email'       => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_string' ) ),
			'image'       => array( 'required' => false, 'validate_callback' => array( $this->validator, 'is_image' ) ),
		);
	}

	/**
	 * @return bool Whether the current user can post or not.
	 */
	public function can_post() {
		$cap = get_post_type_object( Tribe__Events__Main::ORGANIZER_POST_TYPE )->cap->edit_posts;

		return current_user_can( $cap );
	}

	/**
	 * Returns the post type handled by this linked post endpoint.
	 *
	 * @return string
	 *
	 * @since bucket/full-rest-api
	 */
	protected function get_post_type() {
		return Tribe__Events__Main::ORGANIZER_POST_TYPE;
	}

	/**
	 * Whether the data represents a valid post type ID.
	 *
	 * @param mixed $data
	 *
	 * @return bool
	 *
	 * @since bucket/full-rest-api
	 */
	protected function is_post_type( $data ) {
		return tribe_is_organizer( $data );
	}

	/**
	 * Handles DELETE requests on the endpoint.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_Error|WP_REST_Response An array containing the data of the trashed post on
	 *                                   success or a WP_Error instance on failure.
	 */
	public function delete( WP_REST_Request $request ) {
		$organizer_id = $request['id'];

		$organizer = get_post( $organizer_id );

		if ( 'trash' === $organizer->post_status ) {
			$message = $this->messages->get_message( 'organizer-is-in-trash' );

			return new WP_Error( 'organizer-is-in-trash', $message, array( 'status' => 410 ) );
		}

		/**
		 * Filters the organizer delete operation.
		 *
		 * Returning a non `null` value here will override the default trashing operation.
		 *
		 * @param int|bool        $deleted Whether the organizer was successfully deleted or not.
		 * @param WP_REST_Request $request The original API request.
		 *
		 * @since TBD
		 */
		$deleted = apply_filters( 'tribe_organizers_rest_organizer_delete', null, $request );
		if ( null === $deleted ) {
			$deleted = wp_trash_post( $organizer_id );
		}

		if ( false === $deleted ) {
			$message = $this->messages->get_message( 'could-not-delete-organizer' );

			return new WP_Error( 'could-not-delete-organizer', $message, array( 'status' => 500 ) );
		}

		$data = $this->post_repository->get_organizer_data( $organizer_id );

		return is_wp_error( $data ) ? $data : new WP_REST_Response( $data );
	}

	/**
	 * Returns the content of the `args` array that should be used to register the endpoint
	 * with the `register_rest_route` function.
	 *
	 * @return array
	 */
	public function DELETE_args() {
		return $this->READ_args();
	}

	/**
	 * Whether the current user can delete posts of the type managed by the endpoint or not.
	 *
	 * @return bool
	 */
	public function can_delete() {
		$cap = get_post_type_object( Tribe__Events__Main::ORGANIZER_POST_TYPE )->cap->delete_posts;

		return current_user_can( $cap );
	}
}