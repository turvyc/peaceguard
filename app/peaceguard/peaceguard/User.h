//
//  User.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface User : NSObject

//Declaration of variables/object
@property (nonatomic, copy) NSString *username;
@property (nonatomic, copy) NSString *password;
@property (nonatomic) BOOL *authenticated;

//Declare custom initializers
- (id) initWithUsername:(NSString *)username password:(NSString *)password;


@end
