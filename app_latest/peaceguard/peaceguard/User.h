//
//  User.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
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
