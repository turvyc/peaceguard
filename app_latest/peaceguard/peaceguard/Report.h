//
//  Report.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 13 Developer's Group
//


#import <Foundation/Foundation.h>

@interface Report : NSObject

@property (nonatomic, copy) NSString *type;
@property (nonatomic, copy) NSString *severity;
@property (nonatomic, copy) NSString *location;
@property (nonatomic) NSInteger time;
@property (nonatomic, copy) NSString *description;
@property (nonatomic, copy) NSData *image;


-(id) initWithType: (NSString *) type severity: (NSString *) severity location: (NSString *) location time: (NSInteger) time andDescription: (NSString *) description;
-(id) initWithType: (NSString *) type severity: (NSString *) severity location: (NSString *) location time: (NSInteger) time image: (NSData *) image andDescription: (NSString *) description;

@end

